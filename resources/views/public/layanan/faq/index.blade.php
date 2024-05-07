@extends('layouts.public')

@push('css')
<style>
    /* Tab content - closed */
    .tab-content {
        max-height: 0;
        -webkit-transition: max-height .35s;
        -o-transition: max-height .35s;
        transition: max-height .35s;
    }
    /* :checked - resize to full height */
    .tab input:checked ~ .tab-content {
        max-height: 100vh;
    }
    /* Label formatting when open */
    .tab input:checked + label{
    /*@apply text-xl p-5 border-l-2 border-indigo-500 bg-gray-100 text-indigo*/
        font-size: 1.25rem; /*.text-xl*/
        padding: 1.25rem; /*.p-5*/
        border-left-width: 2px; /*.border-l-2*/
        border-color: #6574cd; /*.border-indigo*/
        background-color: #f8fafc; /*.bg-gray-100 */
        color: #6574cd; /*.text-indigo*/
    }
    /* Icon */
    .tab label::after {
        float:right;
        right: 0;
        top: 0;
        display: block;
        width: 1.5em;
        height: 1.5em;
        line-height: 1.5;
        font-size: 1.25rem;
        text-align: center;
        -webkit-transition: all .35s;
        -o-transition: all .35s;
        transition: all .35s;
    }
    /* Icon formatting - closed */
    .tab input[type=checkbox] + label::after {
        content: "+";
        font-weight:bold; /*.font-bold*/
        border-width: 1px; /*.border*/
        border-radius: 9999px; /*.rounded-full */
        border-color: #b8c2cc; /*.border-grey*/
    }
    .tab input[type=radio] + label::after {
        content: "\25BE";
        font-weight:bold; /*.font-bold*/
        border-width: 1px; /*.border*/
        border-radius: 9999px; /*.rounded-full */
        border-color: #b8c2cc; /*.border-grey*/
    }
    /* Icon formatting - open */
    .tab input[type=checkbox]:checked + label::after {
        transform: rotate(315deg);
        background-color: #6574cd; /*.bg-indigo*/
        color: #f8fafc; /*.text-grey-lightest*/
    }
    .tab input[type=radio]:checked + label::after {
        transform: rotateX(180deg);
        background-color: #6574cd; /*.bg-indigo*/
        color: #f8fafc; /*.text-grey-lightest*/
    }
</style>
@endpush

@section('content')
<div class="flex items-center justify-center h-auto p-5 bg-gradient-to-r from-yellow-200 to-green-400">
    <div class="margin-100 w-full mx-auto p-8">
        <div class="shadow-md">
           @foreach ($faqs['data'] as $key => $item)
                <div class="tab w-full overflow-hidden border-t bg-white">
                    <input class="absolute opacity-0 " id="tab-multi-{{$key}}" type="checkbox" name="tabs">
                    <label class="block p-5 leading-normal cursor-pointer" for="tab-multi-{{$key}}">{{$item['title']}}</label>
                    <div class="tab-content overflow-hidden border-l-2 bg-gray-100 border-indigo-500 leading-normal">
                        <div class="p-5">
                            {!! $item['content'] !!}
                        </div>
                    </div>
                </div>
           @endforeach
        </div>
    </div>
</div>
@endsection

@push('script')
<script>
    /* Optional Javascript to close the radio button version by clicking it again */
    var myRadios = document.getElementsByName('tabs2');
    var setCheck;
    var x = 0;
    for(x = 0; x < myRadios.length; x++){
        myRadios[x].onclick = function(){
            if(setCheck != this){
                 setCheck = this;
            }else{
                this.checked = false;
                setCheck = null;
        }
        };
    }
</script>
@endpush
