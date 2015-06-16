
/* =============================================================*
* justParallax.js v3.0
* Developer: Martin Drost
* Documentation: http://www.martindrost.nl/justParallax
* 
* Tests approved: IE6+, Google Chrome, Mozilla Firefox, Safari, Opera
*==============================================================*/
function initParallax(settings)
{
    parallax_settings = {target: select('body'),speed: 8, vertical: true, vertical_inversed: false, horizontal: false, horizontal_inversed: false};
    !settings && (settings = {});
    settings.target && (parallax_settings.target = select(settings.target));
    settings.speed && (parallax_settings.speed = settings.speed);
    settings.vertical === false && (parallax_settings.vertical = settings.vertical);
    settings.vertical_inversed && (parallax_settings.vertical_inversed = settings.vertical_inversed);
    settings.horizontal && (parallax_settings.horizontal = settings.horizontal);
    settings.horizontal_inversed && (parallax_settings.horizontal_inversed = settings.horizontal_inversed);
    

    window.addEventListener && (window.addEventListener('scroll', moveBackground, false));
    !window.addEventListener && window.attachEvent && (window.attachEvent('onscroll', moveBackground));
    
    function moveBackground()
    {
        var doc = document,
            window_height = window.innerHeight || doc.documentElement.clientHeight,
            scrolltop_offset = window.scrollY||(doc.documentElement||doc.body.parentNode||doc.body).scrollTop,
            speed = parallax_settings.speed,
            vertical =  parallax_settings.vertical,
            horizontal = parallax_settings.horizontal,
            horizontal_inversed = parallax_settings.horizontal_inversed?'':'-',
            vertical_inversed = parallax_settings.vertical_inversed?'':'-';
            doc.body.backgroundAttachment != 'fixed' && (doc.body.style.backgroundAttachment  = 'fixed');

        for(var i=0,l=parallax_settings.target.length;i<l;i++)
        {
            var current_target = parallax_settings.target[i],
                target_offset = current_target.offsetTop,
                offsets = scrolltop_offset-target_offset,
                position = target_offset>window_height?(offsets+window_height)/speed:scrolltop_offset/speed;
            
            current_target.style.backgroundPosition = (horizontal?horizontal_inversed+position+'px ':'center ')+(vertical?vertical_inversed+position+'px':'center');
        }
    };
    moveBackground();
}

function select(selection)
{
    var select_array = [],
        targets = selection.split(','),
        doc = document;
    for(var i=targets.length;i>0;i--)
    {
        var item = targets[i-1],
            is_id = is_class = is_tag = false;
    
        item.indexOf('#') !== -1 && (is_id = true) ||
        item.indexOf('.') !== -1 && (is_class = true) ||
        (is_tag = true);
        
        var regex = /[.#\s]/g;
        item = item.replace(regex,'');
        var selected =  is_id && (doc.getElementById(item)) ||
                        is_class && (doc.getElementsByClassName && doc.getElementsByClassName(item) || getElementsByClassName(doc.body,item)) ||
                        is_tag && (doc.getElementsByTagName(item));
                
        select_array = mergeArrays(select_array,selected);
    }
    return select_array;
}

//Fallback for IE8 and lower
function getElementsByClassName(parent, class_name) 
{
    var array = [],
        regex = new RegExp('(^| )'+class_name+'( |$)'),
        elements = parent.getElementsByTagName("*");

    var i = elements.length?elements.length:0;
    !i && regex.test(elements.className) && (array[0] = elements);
    for(;i>0;i--)
    {
        var item = elements[i-1];
        regex.test(item.className) && (array[array.length] = item);
    }
    return array;
}

function mergeArrays(array, add_array) 
{
    var l = add_array.length,
        i = array.length,
        length = i;
    for(;i<l+length;i++)array[i] = add_array[i-length];
    return array;
}
