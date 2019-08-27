<div class="m-portlet m-portlet--tabs">
    <div class="m-portlet__head">
        <div class="m-portlet__head-tools">
            <ul class="nav nav-tabs m-tabs-line" role="tablist">
                <li class="nav-item m-tabs__item">
                    <a class="nav-link m-tabs__link active" data-toggle="tab" href="#m_tabs_6_1"
                       role="tab" style="font-size: 11px">
                        Customization
                    </a>
                </li>
                <li class="nav-item m-tabs__item">
                    <a class="nav-link m-tabs__link" data-toggle="tab" href="#m_tabs_6_2"
                       role="tab" style="font-size: 11px">
                        Time Base Display
                    </a>
                </li>
                <li class="nav-item m-tabs__item">
                    <a class="nav-link m-tabs__link" data-toggle="tab" href="#m_tabs_6_3"
                       role="tab" style="font-size: 11px">
                        Time Base Pricing
                    </a>
                </li>
            </ul>
        </div>
    </div>
    <div class="m-portlet__body">
        <div class="tab-content">
            <div class="tab-pane active" id="m_tabs_6_1" role="tabpanel">
                @include('admin.customizations.reuse.index')
            </div>
            <div class="tab-pane" id="m_tabs_6_2" role="tabpanel">
                @include('admin.time_base_display_rules.reuse.index')
            </div>
            <div class="tab-pane" id="m_tabs_6_3" role="tabpanel">
                @include('admin.time_base_pricing_rules.reuse.index')
            </div>
        </div>
    </div>
</div>