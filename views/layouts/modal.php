<?php
/**
 * @var string $modalId
 * @var string $content
 * @var string $modalClass
 */
?>

<div id="<?php echo isset($this->params['modalId']) ? $this->params['modalId'] : 'modal-id'; ?>" class="modal fade" role="dialog">
    <div class="modal-dialog <?php echo isset($this->params['modalClass']) ? $this->params['modalClass'] : ''; ?>">
        <div class="modal-content">
          <?php echo $content; ?>
        </div>

    </div>
</div>
