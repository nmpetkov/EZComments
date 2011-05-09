{include file="ezcomments_admin_menu.tpl"}
<div class="z-admincontainer">
    <div class="z-adminpageicon">{img modname='EZComments' src='admin.gif' alt=''}</div>
    <h2>{gt text="Delete module"}</h2>
    <p class="z-warningmsg">{gt text="Confirm deletion of all comments attached to module '%s'" tag1=$name}</p>
    <form class="z-form" action="{modurl modname='EZComments' type='admin' func='deletemodule'}" method="post" enctype="application/x-www-form-urlencoded">
        <div>
            <input type="hidden" name="csrftoken" value="{insert name='csrftoken'}" />
            <input type="hidden" name="confirmation" value="1" />
            <input type="hidden" name="modid" value="{$modid|safetext}" />
            <fieldset>
                <legend>{gt text="Confirmation prompt"}</legend>
                <div class="z-buttons z-formbuttons">
                    {button src='button_ok.png' set='icons/small' __alt='Delete' __title='Delete'}
                    <a href="{modurl modname='EZComments' type='admin' func='main'}">{img modname='core' src='button_cancel.png' set='icons/small' __alt='Cancel' __title='Cancel'}</a>
                </div>
            </fieldset>
        </div>
    </form>
</div>
