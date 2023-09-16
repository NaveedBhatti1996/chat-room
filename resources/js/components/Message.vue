<template>
    <div>
        <li class="list-group-item" :class="className"><slot></slot>
            <span class="float-end" id="time">{{this.time}}</span>
        </li>
        <small class="badge float-end text-white" :class="badgeClass">{{this.user}}</small>
    </div>
</template>

<script>
    export default {
    props:[
        'user',
        'time'
    ],
        computed:{
            className(){
                return 'list-group-item-'+this.color;
            },
            badgeClass(){
                return 'bg-'+this.color
            },
            color(){
                return this.user==='you'?'success':'warning'
            }
        }
    }
</script>

<style>
    #time{
        font-size: 9px;
        color:black;
        margin-top: 10px;
    }
</style>
