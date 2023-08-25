<?php
/**
 * OrangeHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for any enterprise.
 * Copyright (C) 2006 OrangeHRM Inc., http://www.orangehrm.com
 *
 * OrangeHRM is free software; you can redistribute it and/or modify it under the terms of
 * the GNU General Public License as published by the Free Software Foundation; either
 * version 2 of the License, or (at your option) any later version.
 *
 * OrangeHRM is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY;
 * without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 * See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along with this program;
 * if not, write to the Free Software Foundation, Inc., 51 Franklin Street, Fifth Floor,
 * Boston, MA  02110-1301, USA
 */

namespace OrangeHRM\Admin\Dao;

use OrangeHRM\Admin\Dto\LicenseSearchFilterParams;
use OrangeHRM\Core\Dao\BaseDao;
use OrangeHRM\ORM\Paginator;
use OrangeHRM\Entity\License;

class LicenseDao extends BaseDao
{
    /**
     * @param License $license
     * @return License
     */
    public function saveLicense(License $license): License
    {
        $this->persist($license);
        return $license;
    }

    /**
     * @param $id
     * @return License|null
     */
    public function getLicenseById($id): ?License
    {
        $license = $this->getRepository(License::class)->find($id);
        if ($license instanceof License) {
            return $license;
        }
        return null;
    }

    /**
     * @param $name
     * @return License|null
     */
    public function getLicenseByName($name): ?License
    {
        $query = $this->createQueryBuilder(License::class, 'l');
        $trimmed = trim($name, ' ');
        $query->andWhere('l.name = :name');
        $query->setParameter('name', $trimmed);
        return $query->getQuery()->getOneOrNullResult();
    }

    /**
     * @param LicenseSearchFilterParams $licenseSearchFilterParams
     * @return array
     */
    public function getLicenseList(LicenseSearchFilterParams $licenseSearchFilterParams): array
    {
        $paginator = $this->getLicenseListPaginator($licenseSearchFilterParams);
        return $paginator->getQuery()->execute();
    }

    /**
     * @param LicenseSearchFilterParams $licenseSearchFilterParams
     * @return Paginator
     */
    public function getLicenseListPaginator(LicenseSearchFilterParams $licenseSearchFilterParams): Paginator
    {
        $q = $this->createQueryBuilder(License::class, 'l');
        $this->setSortingAndPaginationParams($q, $licenseSearchFilterParams);
        return new Paginator($q);
    }

    /**
     * @param LicenseSearchFilterParams $licenseSearchFilterParams
     * @return int
     */
    public function getLicenseCount(LicenseSearchFilterParams $licenseSearchFilterParams): int
    {
        $paginator = $this->getLicenseListPaginator($licenseSearchFilterParams);
        return $paginator->count();
    }

    /**
     * @param array $toDeleteIds
     * @return int
     */
    public function deleteLicenses(array $toDeleteIds): int
    {
        $q = $this->createQueryBuilder(License::class, 'l');
        $q->delete()
            ->where($q->expr()->in('l.id', ':ids'))
            ->setParameter('ids', $toDeleteIds);
        return $q->getQuery()->execute();
    }

    /**
     * @param $licenseName
     * @return bool
     */
    public function isExistingLicenseName($licenseName): bool
    {
        $q = $this->createQueryBuilder(License::class, 'l');
        $trimmed = trim($licenseName, ' ');
        $q->where('l.name = :name');
        $q->setParameter('name', $trimmed);
        $count = $this->count($q);
        if ($count > 0) {
            return true;
        }
        return false;
    }
}
