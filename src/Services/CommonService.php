<?php

declare(strict_types=1);

namespace Focite\Builder\Services;

use Focite\Builder\Contracts\CommonServiceInterface;
use Focite\Builder\Contracts\CurdRepositoryInterface;
use Focite\Builder\Exceptions\CustomException;

/**
 * @method CurdRepositoryInterface getRepository()
 */
abstract class CommonService implements CommonServiceInterface
{
    /**
     * 插入一条记录
     */
    public function save(array $entity): bool
    {
        $insertId = $this->getRepository()->save($entity);

        return $insertId > 0;
    }

    /**
     * 插入（批量）
     */
    public function saveBatch(array $dataSet, int $batchSize = self::DEFAULT_BATCH_SIZE): bool
    {
        $listGroup = array_chunk($dataSet, $batchSize);

        $collections = [];
        foreach ($listGroup as $data) {
            $collections[] = $this->getRepository()->saveAll($data);
        }

        return ! empty($collections);
    }

    /**
     * 批量修改插入
     *
     * @throws CustomException
     */
    public function saveOrUpdateBatch(array $dataSet, int $batchSize = self::DEFAULT_BATCH_SIZE): bool
    {
        throw new CustomException('TODO: Implement saveOrUpdateBatch() method.');
    }

    /**
     * 根据 ID 删除
     */
    public function removeById(int $id): bool
    {
        return $this->getRepository()->deleteById($id);
    }

    /**
     * 根据条件，删除记录
     */
    public function remove(array $condition): bool
    {
        if (empty($condition)) {
            return false;
        }

        return $this->getRepository()->delete($condition);
    }

    /**
     * 删除（根据ID 批量删除）
     */
    public function removeByIds(array $ids): bool
    {
        return $this->getRepository()->deleteAllById($ids);
    }

    /**
     * 根据 ID 选择修改
     */
    public function updateById(array $entity, int $id): bool
    {
        $affectedRow = $this->getRepository()->updateById($entity, $id);

        return $affectedRow > 0;
    }

    /**
     * 根据条件，更新记录
     */
    public function update(array $entity, array $condition): bool
    {
        if (empty($condition)) {
            return false;
        }

        $affectedRow = $this->getRepository()->update($entity, $condition);

        return $affectedRow > 0;
    }

    /**
     * 存在更新记录，否插入一条记录
     *
     * @throws CustomException
     */
    public function saveOrUpdate(array $entity): bool
    {
        throw new CustomException('TODO: Implement saveOrUpdate() method.');
    }

    /**
     * 根据 ID 查询
     */
    public function getById(int $id): array
    {
        return $this->getRepository()->findById($id);
    }

    /**
     * 查询（根据ID 批量查询）
     */
    public function listByIds(array $ids): array
    {
        return $this->getRepository()->findAllById($ids);
    }

    /**
     * 根据条件，查询一条记录
     */
    public function getOne(array $condition): array
    {
        return $this->getRepository()->findByWhere($condition);
    }

    /**
     * 查询某个字段的值
     */
    public function value(string $field, array $condition): mixed
    {
        return $this->getRepository()->value($field, $condition);
    }

    /**
     * 查询某一列的值
     */
    public function pluck(string $field, array $condition): array
    {
        return $this->getRepository()->pluck($field, $condition);
    }

    /**
     * 根据条件，查询总记录数
     */
    public function count(array $condition): int
    {
        return $this->getRepository()->count($condition);
    }

    /**
     * 查询列表
     */
    public function getList(array $condition): array
    {
        return $this->getRepository()->findAll($condition);
    }

    /**
     * 分页查询列表
     */
    public function page(array $condition, int $page, int $perPage = 20): array
    {
        return $this->getRepository()->page($condition, $page, $perPage);
    }
}
