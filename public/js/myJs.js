function salert(data=[]){
    
    let icon = (data.icon)?data.icon:'success';
    let position = (data.position)?data.position:'center';
    let timer = (data.timer)?data.timer:null;
    let title = (data.title)?data.title:'Titulo de prueba';
    let toast = (data.toast)?data.toast:false;
    let text = (data.text)?data.text:'';
    Swal.fire({
        position: position,
        icon: icon,
        title: title,
        showConfirmButton: false,
        toast:toast,
        timer: timer,
        text: text,
    })
 }

 window.addEventListener('salert', event => {
  let icon = (event.detail.icon)?event.detail.icon:'success';
  let position = (event.detail.position)?event.detail.position:'center';
  let timer = (event.detail.timer)?event.detail.timer:null;
  let title = (event.detail.title)?event.detail.title:'Titulo de prueba';
  let toast = (event.detail.toast)?event.detail.toast:false;
  let text = (event.detail.text)?event.detail.text:'';
   salert({
    title:title,
    icon:icon,
    position:position,
    timer:timer,
    toast:toast,
    text:text
    });
})

 window.addEventListener('consolelog', event => {
  let c1 = (event.detail.consolelog)? event.detail.consolelog:'consolelog vacio';

  if (event.detail.consolelog2) {
    console.log(c1,event.detail.consolelog2);
  }else{
    console.log(c1);
  }
   
})

  function number_format(x){
    return Math.round(x).toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
  }


  function scrollIfNeeded(element,container){
    if (element.offsetTop < container.scrollTop) {
        container.scrollTop = element.offsetTop;
    } else {
        const offsetBottom = element.offsetTop + element.offsetHeight;
        const scrollBottom = container.scrollTop + container.offsetHeight;
        if (offsetBottom > scrollBottom) {
        container.scrollTop = offsetBottom - container.offsetHeight;
        }
    }
}




      