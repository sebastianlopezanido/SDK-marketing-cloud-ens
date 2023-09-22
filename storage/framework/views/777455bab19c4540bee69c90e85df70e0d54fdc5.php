<RightOperand xsi:type="SimpleFilterPart">
    <Property>EventDate</Property>
    <SimpleOperator>between</SimpleOperator>
    <DateValue><?php echo e($data['fecha_desde']); ?></DateValue>
    <DateValue><?php echo e($data['fecha_hasta']); ?></DateValue>
</RightOperand>
<?php /**PATH /var/www/html/resources/views/xml/partials/event_date_filter.blade.php ENDPATH**/ ?>