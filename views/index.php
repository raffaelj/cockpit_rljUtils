

<div riot-view>

    <form class="uk-form uk-grid" onsubmit="{ submit }">
    
        <div class="uk-width-medium-1-3" each="{ keys, category in config }">
        
            <h2 class="uk-text-capitalize">{ category }</h2>
        
            <div class="uk-form-row" each="{ status, key in keys }">
            
                <field-boolean bind="config.{category}.{key}" label="{key}"></field-boolean>
            
            </div>
        
        </div>

        <cp-actionbar>
            <div class="uk-container uk-container-center">
                <button class="uk-button uk-button-large uk-button-primary">@lang('Save')</button>
                <a class="uk-button uk-button-link" href="@route('/settings')">
                    <span>@lang('Cancel')</span>
                </a>
            </div>
        </cp-actionbar>
    
    </form>

    <script type="view/script">
        
        var $this = this;
        
        riot.util.bind(this);
        
        this.config = {{ json_encode($config) }};
        
        submit(e) {

            if (e) {
                e.preventDefault();
            }
            
            App.request('/rljutils/saveConfig', {config:this.config}).then(function(data){
                
                console.log(data);
                
            });
            
        }
        
    </script>
    

</div>