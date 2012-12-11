<div class="block">
    <div>
        <div class="widget-options" style="position:relative;">
            <strong style="color:#000">PLEASE SELECT A WIDGET</strong>
            <br /><br /> 
            <div class="the-widget-selection-block" style="padding-left:230px">
                <!-- Let's Hide these guys temporarily for now.
                <div class="widget-preview-box">
                    <div class="widget-previews">
                        <h4>HOSTED SETUP</h4>
                        <img src="/img/hosted-widget-preview.jpg" />
                        <br />
                        <?=HTML::link('feedsetup/hosted_widgets', 'Select', Array('class' => 'white-button'))?>
                        <br />
                        <br />
                    </div>
                    <p>
                        Create your hosted feedback and hosted form.
                    </p>
                </div>

                <div class="widget-preview-box">
                    <div class="widget-previews">
                        <h4>EMBEDDED BLOCK</h4>
                        <img src="/img/embed-widget-preview.jpg" />
                        <br />
                        <?=HTML::link('feedsetup/wizard/embed', 'Select', Array('class' => 'white-button'))?>
                        <br />
                        <br />
                    </div>
                    <p>
                        Embed and integrate your endorsements and testimonials in your website.
                    </p>
                </div>

                <div class="widget-preview-box">
                    <div class="widget-previews">
                        <h4>POPUP DISPLAY</h4>
                        <img src="/img/popup-widget-preview.jpg" />
                        <br />
                        <?=HTML::link('feedsetup/wizard/modal', 'Select', Array('class' => 'white-button'))?>
                        <br />
                        <br />
                    </div>
                    <p>
                       Display your endorsements and testimonials through a modal window.
                    </p>
                </div>
                -->
                <?if($single_submit_widget->submit_count == 0):?>
                    <div class="widget-preview-box">
                        <div class="widget-previews">
                            <h4>SUBMISSION FORM</h4>
                            <img src="/img/submission-widget-preview.jpg" />
                            <br />
                            <?=HTML::link('feedsetup/submission_widgets', 'Select', Array('class' => 'white-button'))?>
                            <br />
                            <br />
                        </div>
                        <p>
                           Create your form for visitors and customers leave feedback.
                        </p>
                    </div>
                <?else:?>
                    <div style="margin-left:-240px">
                        <div class="woops">
                            <h2 class="woops-header">Woops. Well this is embarrassing.</h2><br/><br/>
                            <p class="woops-content">
                                You already have an existing submission form widget.
                            </p>
                        </div>
                    </div>
                <?endif?>

            </div>                
        </div>
    </div>
    <div class="c"></div>
    <div class="block noborder" style="height:300px;"></div>
</div>
