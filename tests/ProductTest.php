<?php

namespace App\Tests;

use App\Entity\Product;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ProductTest extends WebTestCase
{
    /** @var Client */
    protected $client;
    /** @var EntityManager */
    protected $em;

    /**
     * Set up client and begin doctrine transaction
     */
    protected function setUp()
    {
        parent::setUp();
        $this->client = self::createClient();
        $this->em = $this->client->getContainer()->get('doctrine.orm.entity_manager');
        $this->em->beginTransaction();
    }

    /**
     *  roll back transaction
     */
    protected function tearDown()
    {
        parent::tearDown();
        $this->em->rollback();
    }

    public function testListProduct()
    {
        $crawler = $this->client->request('GET', "/product/list/");
        $this->assertGreaterThan(
            0,
            $crawler->filter('html:contains("Picture")')->count()
        );
    }

    public function testCreateProduct()
    {
        $data = ["name" => "testProduct", "price" => "10", "description" => "description", "picture" => "test.png"];
        $this->client->request('POST', "/product/create/", $data);
        /** @var Product $product */
        $product = $this->em->getRepository(Product::class)->findOneBy(["name" => $data["name"]]);
        $this->assertEquals($product->getPrice(), $data["price"]);
    }

    public function testUpdateProduct()
    {
        $product = $this->em->getRepository(Product::class)->findOneBy([]);
        $updatedData = ["name" => "updatedProduct", "price" => "10", "description" => "description", "picture" => "test.png"];
        $this->client->request('POST', "/product/update/?id={$product->getId()}", $updatedData);
        /** @var Product $updatedProduct */
        $updatedProduct = $this->em->getRepository(Product::class)->find($product->getId());
        $this->assertEquals($updatedProduct->getName(), $updatedData["name"]);
    }

    public function testDeleteProduct()
    {
        /** @var Product $product */
        $product = $this->em->getRepository(Product::class)->findOneBy([]);
        $this->client->request('POST', "/product/delete/?id={$product->getId()}");
        $this->assertTrue($this->client->getResponse()->isSuccessful());
    }
}