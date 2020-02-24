<?php
namespace App\GraphQL\Resolver;


use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Overblog\GraphQLBundle\Definition\Argument;
use Overblog\GraphQLBundle\Definition\Resolver\AliasedInterface;
use Overblog\GraphQLBundle\Definition\Resolver\ResolverInterface;

class ProductResolver implements ResolverInterface, AliasedInterface
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
        return $this->em->getRepository(Product::class)->find($arguments['id']);
    }

    /**
     * @inheritDoc
     */
    public static function getAliases(): array
    {
        return [
            'resolve' => 'Product'
        ];
    }
}