<?php

namespace App\View\Components\site;

use Illuminate\View\Component;

class PostingPlanList extends Component
{
    private const DEFAULT_COL = '12';
    private const DEFAULT_COL_MD = '4';
    private const DEFAULT_COL_SM = '6';

    public $plans;
    public $userPlan;

    public ?string $mb;
    public ?string $sm;
    public ?string $md;
    public ?string $lg;
    public ?string $xl;

    public function __construct(
        $plans,
        $userPlan,
        $mb = self::DEFAULT_COL,
        $sm = self::DEFAULT_COL_SM,
        $md = self::DEFAULT_COL_SM,
        $lg = self::DEFAULT_COL_MD,
        $xl = self::DEFAULT_COL_MD,
    )
    {
        $this->plans = $plans;
        $this->userPlan = $userPlan;
        $this->mb = $mb;
        $this->sm = $sm;
        $this->md = $md;
        $this->lg = $lg;
        $this->xl = $xl;
    }

    public function render()
    {
        return view('site.components.post-plan.list-posting-plan');
    }
}
