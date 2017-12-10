<template>
    <div></div>
</template>
<script>
    export default {
        props: ['message'],

        data() {
            return {
                body: this.message,
                level: 'success'
            }
        },

        created() {
            if (this.message) {
                this.flash();                
            }

            window.events.$on('flash', data => {
                this.flash(data);
            });
        },

        methods: {
            flash(data) {
                console.log('something');
                if(data) {
                    this.body = data.message;
                    this.level = data.level;
                }
                
                $.toast({
                    heading: 'Information',
                    text: this.body,
                    position: 'top-right',
                    loaderBg: '#fec107',
                    icon: this.level,
                    hideAfter: 3500 
                }); 
            },
        }
    };
</script>