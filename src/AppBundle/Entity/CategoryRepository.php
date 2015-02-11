<?php
namespace AppBundle\Entity;

use AppBundle\Helper\ListParameters;

/**
 * CategoryRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CategoryRepository extends ResourceRepository
{
    /**
     * @param ListParameters $params
     *
     * @return \Knp\Component\Pager\Pagination\PaginationInterface
     */
    public function getList(ListParameters $params)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('c')
            ->from('AppBundle:Category', 'c')
            ->orderBy('c.sort', 'ASC');

        $categories = $this->getPaginator()->paginate($qb, $params->getPage(), $params->getLimit());

        return $categories;
    }

    /**
     * @param int $id
     *
     * @return Category
     */
    public function getOne($id)
    {
        /**
         * @var \AppBundle\Entity\Category $category
         */
        $category = $this->findOneBy(['id' => $id]);

        return $category;
    }
}
