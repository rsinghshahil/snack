<template>
    <div>
        <div :id="modalId" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="my-modal-title">
                            <slot name="title"></slot>
                        </h5>
                        <button class="close" data-dismiss="modal" aria-label="Close">
                            <i class="flaticon2-cross"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <slot></slot>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        modalId: {
            type: String,
            default: 'myModal'
        },
    }
}
</script>
