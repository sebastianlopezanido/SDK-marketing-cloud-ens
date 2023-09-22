<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
    <soapenv:Header>
        <wsse:Security soapenv:mustUnderstand="1" xmlns:wsse="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd">
            <wsse:UsernameToken wsu:Id="UsernameToken-24440876" xmlns:wsu="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-utility-1.0.xsd">
                <wsse:Username><?php echo e(config('constants.mkc.et_username')); ?></wsse:Username>
                <wsse:Password Type="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-username-token-profile-1.0#PasswordText"><?php echo e(config('constants.mkc.et_password')); ?></wsse:Password>
            </wsse:UsernameToken>
        </wsse:Security>
    </soapenv:Header>
    <soapenv:Body>
        <RetrieveRequestMsg xmlns="http://exacttarget.com/wsdl/partnerAPI">
            <RetrieveRequest>
                <ObjectType><?php echo e($data['object']); ?></ObjectType>
                <?php $__currentLoopData = $data['propiedades']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $propiedad): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <Properties><?php echo e($propiedad); ?></Properties>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <Filter xsi:type="ComplexFilterPart" >
                    <?php if(isset($data['filtro_subscriber_key'])): ?>
                        <LeftOperand xsi:type="ComplexFilterPart">
                            <?php echo $__env->make('xml.partials.triggered_send_definition_filter', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            <LogicalOperator>AND</LogicalOperator>
                            <?php echo $__env->make('xml.partials.event_date_filter', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        </LeftOperand>
                        <LogicalOperator>AND</LogicalOperator>
                        <?php echo $__env->make('xml.partials.subscriber_key_filter', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    <?php else: ?>
                        <?php echo $__env->make('xml.partials.triggered_send_definition_filter', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        <LogicalOperator>AND</LogicalOperator>
                        <?php echo $__env->make('xml.partials.event_date_filter', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    <?php endif; ?>
                </Filter>
            </RetrieveRequest>
        </RetrieveRequestMsg>
    </soapenv:Body>
</soapenv:Envelope>
<?php /**PATH /var/www/html/resources/views/xml/retrieve_sent_object.blade.php ENDPATH**/ ?>