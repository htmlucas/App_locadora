<template>
    <div class="form-row">
        <label :for="id" class="col col-form-label">{{titulo}}</label>
        <slot></slot>
        <div class="col-auto">
            <div :id="idHelp" class="form-text text-muted">{{textoAjuda}}</div>
        </div>
    </div>

</template>

<script>
    export default {
        props: ['id', 'titulo', 'idHelp', 'textoAjuda']
    }
</script>
