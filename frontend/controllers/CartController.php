<?php

namespace frontend\controllers;

use common\components\FunctionHelper;
use common\models\Customer;
use common\models\OrderProduct;
use common\models\ProductQuantity;
use frontend\components\NovaPoshtaApi2;
use Yii;
use common\models\Order;
use common\models\OrderProducts;
use common\models\Product;
use common\models\User;
use yii\web\Response;
use yz\shoppingcart\ShoppingCart;

class CartController extends CommonController
{

    public function actionAdd($id, $w)
    {
        if (($product = Product::findOne($id)) && ($pq = $product->getQuantityWarehouse($w)) && $pq->price > 0 && $pq->count > 0) {
            $product->detachBehaviors(); // fix Serialization of 'Closure' is not allowed
            $product->costWarehouseId = $w;
            \Yii::$app->cart->put($product);

            \Yii::$app->session->setFlash('success', 'Товар &laquo;' . $product->name . '&raquo; добавлен в корзину.');
            //return $this->redirect(\Yii::$app->request->referrer);
            return $this->redirect(['cart/list']);
        }
        return $this->redirect(['cart/list']);
    }

    public function actionList()
    {
        /* @var $cart ShoppingCart */
        $cart = \Yii::$app->cart;

        $products = $cart->getPositions();
        $total    = $cart->getCost();

        return $this->render('list', [
            'products' => $products,
            'total'    => $total,
        ]);
    }

    public function actionRemove($id)
    {
        if ($product = Product::findOne($id)) {
            Yii::$app->session->setFlash('danger', 'Товар &laquo;' . $product->name . '&raquo; удален из корзины.');
            Yii::$app->cart->remove($product);
            $this->redirect(['cart/list']);
        }
    }

    public function actionUpdate($id, $quantity, $w)
    {
        if ($product = Product::findOne($id)) {
            $pq = $product->getQuantityWarehouse($w);

            if ($quantity > $pq->count) {
                \Yii::$app->session->setFlash('error', 'Перевищено доступну кількість товару.');
                return $this->redirect(['cart/list']);
            }

            \Yii::$app->cart->update($product, $quantity);
            return $this->redirect(['cart/list']);
        }

        throw new \yii\web\NotFoundHttpException('Товар не знайдено.');
    }


    public function actionOrder()
    {
        $customer = Customer::findOne(Yii::$app->user->getId());
        if (!$customer) {
            $customer = false;
        }
        $order = new Order($customer, [
            'scenario' => Order::SCENARIO_SITE
        ]);

        /* @var $cart ShoppingCart */
        $cart = \Yii::$app->cart;

        /* @var $products Product[] */
        $products = $cart->getPositions();
        $total    = $cart->getCost();

        if ($order->load(\Yii::$app->request->post()) && $order->validate()) {
            $transaction = $order->getDb()->beginTransaction();
            //$order->o_total = $total;
            $total = 0;

            if (!empty($order->np_city)) {
                Yii::debug('City before: ' . $order->np_city);
                $order->np_city_ref = $order->np_city;
                $np                 = \common\components\NovaPoshtaApi2::getInstance();
                $order->np_city     = $np->getCityByRef($order->np_city_ref);
                Yii::debug('City after: ' . $order->np_city);
                $order->np_warehouse_ref = $np->getWarehouseRef($order->np_city_ref, $order->np_warehouse);
            }

            if (!$order->save(false)) {
                Yii::error($order->getFirstErrors());
            }
            // create Customer
            if (Yii::$app->user->isGuest) {

                // try to find customer
                $tel = FunctionHelper::phoneNumberSanitize($order->c_tel);
                $customer = Customer::find()
                ->where(['email' => $order->c_email])
                ->orWhere(['tel' => $tel])
                ->one();

                if(!$customer) {
                    $user           = new User();
                    $user->username = $order->c_email;
                    $user->email    = $order->c_email;
                    $user->status   = User::STATUS_ACTIVE;
                    $user->setPassword(Yii::$app->security->generateRandomString(8));
                    $user->generateAuthKey();
                    $user->generateEmailVerificationToken();

                    if ($user->save()) {
                        [$lastname, $firstname, $middlename] = array_pad(explode(' ', $order->c_fio), 3, '');
                        $customer = new Customer([
                            'id'                 => $user->id,
                            'lastname'           => $lastname,
                            'firstname'          => $firstname,
                            'middlename'         => $middlename,
                            'tel'                => $order->c_tel,
                            'email'              => $order->c_email,
                            'city'               => $order->o_city,
                            'address'            => $order->o_address,
                            'carrier'            => $order->o_shipping,
                            'carrier_city'       => $order->np_city,
                            'carrier_city_ref'   => $order->np_city_ref,
                            'carrier_region'     => $order->np_region,
                            'carrier_region_ref' => $order->np_region_ref,
                            'carrier_branch'     => $order->np_warehouse,
                            'carrier_branch_ref' => $order->np_warehouse_ref,
                        ]);
                        //$customer->setScenario($customer::SCENARIO_CREATE);
                        if ($customer->save()) {
                            $order->updateAttributes(['id_customer' => $customer->id]);
                        } else {
                            $transaction->rollBack();
                            throw new \yii\base\ErrorException(implode(PHP_EOL, $customer->getFirstErrors()));
                        }
                    } else {
                        $transaction->rollBack();
                        throw new \yii\base\ErrorException(implode(PHP_EOL, $user->getFirstErrors()));
                    }
                }
                $order->updateAttributes(['id_customer' => $customer->id]);
            }

            foreach ($products as $product) {
                $orderItem               = new OrderProduct();
                $orderItem->id_order     = $order->id;
                $orderItem->id_product   = $product->id;
                $orderItem->id_warehouse = $product->costWarehouseId;
                $orderItem->product_name = $product->name;
                $orderItem->upc          = $product->upc;
                $orderItem->price        = $product->getCost();
                $orderItem->quantity     = $product->getQuantity();

                if (!$orderItem->save(false)) {
                    $transaction->rollBack();
                    \Yii::$app->session->addFlash('error', 'Ошибка при создании заказа. Пожалуйста, свяжитесь с нами.');
                    return $this->redirect('/cart/list');
                }
                $total += $orderItem->price * $orderItem->quantity;
            }

            $order->updateAttributes(['o_total' => $total]);

            $transaction->commit();
            \Yii::$app->cart->removeAll();

            \Yii::$app->session->addFlash('success', 'Спасибо, ваш заказ был отправлен!<br>Наш менеджер свяжется с Вами в ближайшее время.');
            //$order->sendEmail();

            return $this->redirect('order-success');
        }
        return $this->render('order', [
            'order'    => $order,
            'products' => $products,
        ]);
    }

    public function actionOrderSuccess()
    {
        return $this->render('order_success');
    }

    public function actionNpCities($q)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $out                        = [];

        $np        = \common\components\NovaPoshtaApi2::getInstance();
        $responses = $np->getCities(0, $q);

        if (is_array($responses) && isset($responses['data'])) {
            foreach ($responses['data'] as $res) {
                $out['results'][] = ['id' => $res['Ref'], 'text' => $res['Description']];
            }
        }
        return $out;
    }

    public function actionNpWarehouses()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $out                        = [];
        if (isset($_POST['depdrop_parents'])) {
            $id = end($_POST['depdrop_parents']);

            $np        = \common\components\NovaPoshtaApi2::getInstance();
            $responses = $np->getWarehouses($id);

            if (isset ($responses['data']) && is_array($responses['data']) && count($responses['data']) > 0) {
                foreach ($responses['data'] as $res) {
                    $out[] = ['id' => $res['Description'], 'name' => $res['Description']];
                }
                // Shows how you can preselect a value
                return ['output' => $out, 'selected' => ''];
            }
        }
        return ['output' => '', 'selected' => ''];
    }
}
