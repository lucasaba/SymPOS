<?php
namespace App\GraphQL\Resolver;


use App\Entity\Category;
use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Overblog\GraphQLBundle\Definition\Argument;
use Overblog\GraphQLBundle\Definition\Resolver\AliasedInterface;
use Overblog\GraphQLBundle\Definition\Resolver\ResolverInterface;

class CategoryResolver implements ResolverInterface, AliasedInterface
{
    /**
     * @var EntityManagerInterface
     */
    protected EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function resolve(Argument $arguments)
    {
        return $this->em->getRepository(Category::class)->find($arguments['id']);
    }

    /**
     * @param Argument $args
     *
     * @return Category
     */
    public function addCategory(Argument $args): Category
    {
        $rawArgs = $args->getArrayCopy();

        $category = new Category();
        $category->setName($rawArgs['input']['name'])
            ->setImage($rawArgs['input']['image']);

        if (isset($rawArgs['input']['products'])) {
            foreach ($rawArgs['input']['products'] as $product) {
                $productEntity = new Product();
                $productEntity->setName($product['name'])
                    ->setPrice($product['price'])
                    ->setImage($product['image']);
                $this->em->persist($productEntity);
                $category->addProduct($productEntity);
            }
        }

        $this->em->persist($category);
        $this->em->flush();

        return $category;
    }

    /**
     * @inheritDoc
     */
    public static function getAliases(): array
    {
        return [
            'resolve' => 'Category'
        ];
    }
}