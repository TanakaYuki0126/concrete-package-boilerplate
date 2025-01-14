<?php

namespace Concrete\Package\V9PackageBoilerplate\Controller\SinglePage\Dashboard\Products;

use Concrete\Core\Page\Controller\DashboardPageController;
use Concrete\Core\Url\Resolver\Manager\ResolverManagerInterface;
use Concrete\Core\Utility\Service\Validation\Numbers;
use Macareux\Boilerplate\Entity\Product;
use Macareux\Boilerplate\Entity\ProductRepository;

class Detail extends DashboardPageController
{
    public function view($id = null)
    {
        if ($id) {
            $product = $this->getEntity((int) $id);
            if ($product) {
                $this->set('id', $id);
                $this->set('name', $product->getName());
                $this->set('price', $product->getPrice());
            }
        }
    }

    public function form($id = null)
    {
        $this->set('pageTitle', t('Add Product'));
        if ($id) {
            $product = $this->getEntity((int) $id);
            if ($product) {
                $this->set('id', $id);
                $this->set('name', $product->getName());
                $this->set('price', $product->getPrice());
                $this->set('pageTitle', t('Edit Product'));
            }
        }

        //どのテンプレートが表示に使われているか。
        //指定がない場合は、controllerと同じPathのものが読み込まれる。
        $this->render('/dashboard/products/form', 'v9_package_boilerplate');
    }

    public function submit($id = null)
    {
        // ここは決まり文句。CSRF対策
        //'save_product'は、viewのoutputメソッドの引数に
        if (!$this->token->validate('save_product')) {
            $this->error->add($this->token->getErrorMessage());
        }

        //viewの、フォームの送信
        //'name'はフォームのキーと合わせる。
        $name = $this->get('name');
        //必須チェック。書き方は決まってる。
        if (empty($name)) {
            $this->error->add(t('Please input name.'));
        }

        //Validationの名前空間の中に色々バリデーションに使えるクラスが用意されている。
        $price = $this->get('price');
        /** @var Numbers $numbersValidator */
        $numbersValidator = $this->app->make(Numbers::class);
        if (!$numbersValidator->number($price)) {
            $this->error->add(t('Please input valid price'));
        }

        //エラーがない時
        if (!$this->error->has()) {
            //既存のデータ修正の時
            if ($id) {
                $product = $this->getEntity((int) $id);
                $product->setName((string) $name);
                $product->setPrice((float) $price);
            } else {
                //新規登録の時
                $product = new Product((string) $name, (float) $price);
            }

            $this->entityManager->persist($product);
            $this->entityManager->flush();

            //決まった書き方。
            $this->flash('success', t('Successfully saved.'));

            //このコントローラーのメソッドにリダイレクトしている。
            return $this->buildRedirect($this->action('view', $product->getId()));
        }

        $this->flash('error', $this->error->toText());
        $this->form($id);
    }

    public function delete($id)
    {
        if (!$this->token->validate('delete_product')) {
            $this->error->add($this->token->getErrorMessage());
        }

        $product = $this->getEntity($id);
        if (!$product) {
            $this->error->add(t('Invalid Product.'));
        }

        if (!$this->error->has()) {
            $this->entityManager->remove($product);
            $this->entityManager->flush();

            $this->flash('success', t('Successfully Deleted.'));
            /** @var ResolverManagerInterface $resolver */
            $resolver = $this->app->make(ResolverManagerInterface::class);

            return $this->buildRedirect($resolver->resolve(['/dashboard/products/search']));
        }

        $this->flash('error', $this->error->toText());

        return $this->buildRedirect($this->action('view', $id));
    }

    /**
     * @param int $id
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     *
     * @return Product|null
     */
    protected function getEntity(int $id): ?Product
    {
        /** @var ProductRepository $repository */
        $repository = $this->entityManager->getRepository(Product::class);

        return $repository->find($id);
    }
}
