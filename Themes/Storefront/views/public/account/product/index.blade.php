@extends('public.account.layout')

@section('title', trans('storefront::account.pages.products'))

@section('panel')

    <div class="panel">
        <div class="panel-header">
            <h4>{{ trans('storefront::account.pages.products') }}</h4>
            @if(isset($errors))
        
            {{session()->get('error')}}
            @endif
            @if(session()->has('success'))

            {{session()->get('success')}}
            @endif
     
        </div>
        <div class="container" style="padding-top: 40px">
        <form method="POST" action="{{ route('account.products.add') }}" class="form-horizontal" enctype="multipart/form-data"  novalidate >
         {{ csrf_field() }}
                {{ Form::text('name', trans('product::attributes.name'), $errors, $product, ['labelCol' => 2, 'required' => true]) }}
                {{ Form::text('price', trans('product::attributes.price'), $errors, $product, ['labelCol' => 2, 'required' => true]) }}
                {{ Form::wysiwyg('description', trans('product::attributes.description'), $errors, $product, ['labelCol' => 2, 'required' => true]) }}
                <input type="hidden" name="user_id" value="{{auth()->user()->id}}">
                <div class="row">
                    <div class="col-md-10">    
                    {{ Form::select('categories', trans('product::attributes.categories'), $errors, $categories, $product, ['class' => 'selectize prevent-creation category_select', 'multiple' => true,'required' => true,'onchange' => 'categorSelected(this.value)'])  }}
                      <input type="file" class="form-control " name="images[]" id="images" required multiple> 
                     </div>

                </div>
              
                <div class="row" id="documents" style="display:none;margin-top:10px">
                    <div class="form-group">
                    <label for="Document" class="col-md-2 control-label text-left">Document<span class="m-l-5 text-red"></span></label>
                    <ul class="text-red"id="documents_text" style="display:none;color:red">Please upload </ul>
                    <div class="col-md-10"><input type="file" class="form-control" name="documents[]"   multiple></div>
                   
                    </div>
                </div>
                <br><br>
               
                <div class="form-group">
                <button type="submit" class="btn btn-info">Submit</button>
                </div>
            </form>
        </div>    
    </div>
    <script>
    function categorSelected(selected){
        console.log(selected)
        <?php foreach($documents as $doc){?>
       if(selected=={{$doc}}){
                document.getElementById('documents').style.display = 'block'; 
                document.getElementById('documents_text').style.display = 'block'; 
                var node = document.createElement("LI");                
                var textnode = document.createTextNode("{{$documents_text[$doc]}}");        
                node.appendChild(textnode);                             
                document.getElementById("documents_text").appendChild(node); 
             
       }
    <?php }?>
    }
    </script>
@endsection
