$(document).on("change","div#question select#question-type",function(){
    
    var id = $(this).val();
    
    $("div#type button#add-option").remove();
    $("div.option-item").remove();
    
    if(id == 2 || id == 3)
    {
               
        var button = $("<button type='button' id='add-option'>Add Option</button>");

        $("div#type").append(button);
    }
    
});

$(document).on("click","div.option-item",function(){

    $("div.option-item").removeClass("selected");
    
    
    $("div.option-item").each(function (key,value){ 
        
        var upDown = $(this).find("div.up-down");
        
        $(upDown).remove();
    });  
    
    $(this).addClass("selected");
    
    var divUpdown = $("<div class='up-down'><a href='#' class='up'>&#9652;</a><a href='#' class='down'>&#9662;</a></div>");
        
    if($(this).find("div.up-down").length == 0)    
    {
        $(this).append(divUpdown);
    }
    
});


$(document).on("click","div.comp-item",function(){

    $("div.comp-item").removeClass("selected");
    
    
    $("div.comp-item").each(function (key,value){ 
        
        var upDown = $(this).find("div.up-down");
        
        $(upDown).remove();
    });  
    
    $(this).addClass("selected");
    
    var divUpdown = $("<div class='up-down'><a href='#' class='up'>&#9652;</a><a href='#' class='down'>&#9662;</a></div>");
        
    if($(this).find("div.up-down").length == 0)    
    {
        $(this).append(divUpdown);
    }
    
});



$(document).on("click","div.option-item div.up-down a.down", function(){
    
    var element = $(this).closest("div.option-item");
    
    var list = $("div.option-item");
    
    var length = $(list).length;
    
    var index = $(list).index(element);
    
    var last = false;
    
    if(index == length -1)
    {
        last = true;
    }
    
    if(!last)
    {
        $($(list).get(index + 1)).after(element);
    }
    
    return false;
    
});


$(document).on("click","div.option-item div.up-down a.up", function(){
    
    var element = $(this).closest("div.option-item");
    
    var list = $("div.option-item");
    
    var index = $(list).index(element);
    
    var first = false;
    
    if(index == 0)
    {
        first = true;
    }
    
    if(!first)
    {
        $($(list).get(index - 1)).before(element);
    }
    
    return false;
    
});







$(document).on("click","div.comp-item div.up-down a.down", function(){
    
    var element = $(this).closest("div.comp-item");
    
    var list = $("div.comp-item");
    
    var length = $(list).length;
    
    var index = $(list).index(element);
    
    var last = false;
    
    if(index == length -1)
    {
        last = true;
    }
    
    if(!last)
    {
        $($(list).get(index + 1)).after(element);
    }
    
    return false;
    
});


$(document).on("click","div.comp-item div.up-down a.up", function(){
    
    var element = $(this).closest("div.comp-item");
    
    var list = $("div.comp-item");
    
    var index = $(list).index(element);
    
    var first = false;
    
    if(index == 0)
    {
        first = true;
    }
    
    if(!first)
    {
        $($(list).get(index - 1)).before(element);
    }
    
    return false;
    
});











$(document).on("click","button#add-option",function(){
    
    var id = $(this).closest("div#type").find("select").val();
    
    if(id == 2)
    {
        var count = $("div.option-item").length;
        
        var divOption = $("<div class='option-item'></div>");
        
        var radio = $("<input type='radio' checked disabled>");
        
        var optionText = $("<input type='text' name='option-" + (count + 1) + "'>");
        
        var deleteButton = $("<button type='button' class='delete' id='delete-option'>X</button>");
         
        $(divOption).append(radio);
        $(divOption).append(optionText);
        $(divOption).append(deleteButton);
        
        $("div#options").append(divOption);
    }
    else if (id == 3)
    {
        var count = $("div.option-item").length;
        
        var divOption = $("<div class='option-item'></div>");
        
        var radio = $("<input type='checkbox' checked disabled>");
        
        var optionText = $("<input type='text' name='option-" + (count + 1) + "'>");
        
        var deleteButton = $("<button type='button' class='delete' id='delete-option'>X</button>");
        
        
        
        $(divOption).append(radio);
        $(divOption).append(optionText);
        $(divOption).append(deleteButton);
        
        $("div#options").append(divOption);
    }
    
});


$(document).on("click","button#delete-option",function(){
    
    $(this).closest("div.option-item").remove();
    
});



$(document).on("change","select#add-document",function(){
    
    var id = $(this).val();
    
    if(id != -1)
    {
        var text = $("select#add-document option:selected").text();
        
        var divDocument = $("<div class='document-item comp-item'></div>");
        
        var spanDocument = $("<span>" + text + "</span>");
        
        var hiddenId = $("<input type='hidden' name='document-" + id + "' value='" + id + "'>");
        
        var deleteButton = $("<button type='button' class='delete' id='remove-document'>X</button>");
        
        $(divDocument).append(spanDocument);
        $(divDocument).append(hiddenId);
        $(divDocument).append(deleteButton);
        
        $("div#items").append(divDocument);
        
        $("select#add-document option:selected").removeAttr("selected");
    }
    
 
  });
  
  
  $(document).on("change","select#add-question",function(){
    
    var id = $(this).val();
    
    if(id != -1)
    {
        var text = $("select#add-question option:selected").text();
        
        var divQuestion = $("<div class='question-item comp-item'></div>");
        
        var spanQuestion = $("<span>" + text + "</span>");
        
        var hiddenId = $("<input type='hidden' name='question-" + id + "' value='" + id + "'>");
        
        var deleteButton = $("<button type='button' class='delete' id='remove-question'>X</button>");
        
        $(divQuestion).append(spanQuestion);
        $(divQuestion).append(hiddenId);
        $(divQuestion).append(deleteButton);
        
        $("div#items").append(divQuestion);
        
        $("select#add-question option:selected").removeAttr("selected");
    }
    
 
});
  
$(document).on("click","button#remove-document",function(){
    
    $(this).closest("div.document-item").remove();
    
});

$(document).on("click","button#remove-question",function(){
    
    $(this).closest("div.question-item").remove();
    
});




$(document).on("click","button#submit-document",function(){
    
    $("div.warning").empty();
    
    var isValid = true;
    var hasName = true;
    var hasFile = true;
    
    var name = $("#document-name").val();
    
    if(name == "")
    {
        hasName = false;
        isValid = false;
    }
    
    var file = $("#file").val();
    
    if(file == null || file == "")
    {
        hasFile = false;
        isValid = false;
    }
    
    if(!isValid)
    {
        if(!hasName)
        {
            var noName = "Document name can't be empty!<br/>";
            
            $("div.warning").append(noName);
        }
        if(!hasFile)
        {
            var noFile = "You must load a file!<br/>";
            
            $("div.warning").append(noFile);
        }
        
        return false;
    }
    
});



$(document).on("click","button#update-document",function(){
    
    $("div.warning").empty();
    
    var isValid = true;
    var hasName = true;
    
    var name = $("#document-name").val();
    
    if(name == "")
    {
        hasName = false;
        isValid = false;
    }
    

    
    if(!isValid)
    {
        if(!hasName)
        {
            var noName = "Document name can't be empty!<br/>";
            
            $("div.warning").append(noName);
        }
        
        
        return false;
    }
    
});




$(document).on("click","button#submit-compilation",function(){
    
    $("div.warning").empty();
    
    var isValid = true;
    var hasName = true;
    var hasItems = true;
    
    var name = $("#compilation-name").val();
    
    if(name == "")
    {
        hasName = false;
        isValid = false;
    }
    
    var itemCount = $("div.comp-item").length;
    
    if(itemCount == 0)
    {
        hasItems = false;
        isValid = false;
    }
    
    if(!isValid)
    {
        if(!hasName)
        {
            var noName = "Compilation name can't be empty!<br/>";
            
            $("div.warning").append(noName);
        }
        if(!hasItems)
        {
            var noItems = "Compilation must have content!<br/>";
            
            $("div.warning").append(noItems);
        }
        
        return false;
    }
    
});




$(document).on("click","button#submit-question",function(){
    
    $("div.warning").empty();
    
    var isValid = true;
    var hasName = true;
    var hasText = true;
    var hasOptions = true;
    var optionEmpty = false;
    
    var name = $("#question-name").val();
    
    if(name == "")
    {
        hasName = false;
        isValid = false;
    }
    
    var text = $("#question-text").val();
    
    if(text == "")
    {
        hasText = false;
        isValid = false;
    }
    
    var questionType = $("select#question-type").val();
    
    if(questionType == 2 || questionType == 3)
    {
        var optionCount = $("div.option-item").length;
        
        if(optionCount == 0)
        {
            hasOptions = false;
            isValid = false;
        }
        else
        {
            $("div.option-item input[type='text']").each(function(key,value){
                
                if($(value).val() == "")
                {
                    optionEmpty = true;
                    isValid = false;
                }
                
            });
        }
    }
    

    if(!isValid)
    {
        if(!hasName)
        {
            var noName = "Question name can't be empty!<br/>";
            
            $("div.warning").append(noName);
        }
        if(!hasText)
        {
            var noText = "Question text can't be empty!<br/>";
            
            $("div.warning").append(noText);
        }
        if(!hasOptions)
        {
            var noOptions= "Question must have options!<br/>";
            
            $("div.warning").append(noOptions);
        }
        if(optionEmpty)
        {
            var emptyOption = "Options can't be empty!<br/>";
            
            $("div.warning").append(emptyOption);
        }
        
        return false;
    }
    
});