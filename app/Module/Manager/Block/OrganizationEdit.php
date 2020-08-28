<?php

namespace App\Module\Manager\Block;

use App\Block\AbstractBlock;
use App\Module\Manager\Models\Data\Organization;
use App\Module\Manager\Models\OrganizationRepository;
use App\Module\Manager\Models\PlanRepository;
use Illuminate\Support\Facades\Request;

class OrganizationEdit extends AbstractBlock
{
    /**
     * @var Organization
     */
    private $organization;

    /**
     * OrganizationEdit constructor.
     * @param Organization $organization
     */
    public function __construct(Organization $organization)
    {
        $this->organization = $organization;
    }

    /**
     * @return Organization
     */
    public function getOrganization()
    {
        return $this->organization;
    }

    /**
     * @return array
     */
    public function getAllPlans()
    {
        $result = [];
        $allPlans = (new PlanRepository())->getAll();
        foreach ($allPlans as $plan) {
            $result[$plan->getId()]['id'] = $plan->getId();
            $result[$plan->getId()]['name'] = $plan->getName();
        }
        return $result;
    }

    /**
     * @return void
     * @throws \Exception
     */
    public function update()
    {
        $posts = Request::post();

        $organization = $this->organization;
        $organization->setName($posts['name']);
        $organization->setDomain($posts['domain']);
        $organization->setEmail($posts['email']);
        $organization->setPhoneNumber($posts['phone_number']);
        $organization->setRegisterDate($posts['register_date']);
        $organization->setTaxNumber($posts['tax_number'] ?: '');
        $organization->setAddress($posts['address'] ?: '');
        $organization->setDescription($posts['description'] ?: '');

        $repo = new OrganizationRepository();
        $repo->save($organization);
    }
}
