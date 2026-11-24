/* Sanbada C homepage. Craft guided by unslop by Damir Sokolovsky (@heydamir), CC BY 4.0. */
(() => {
  const reduced = () => matchMedia('(prefers-reduced-motion: reduce)').matches;
  const photoCache = new Map();
  function loadPhoto(url) {
    if (photoCache.has(url)) return photoCache.get(url);
    const promise = new Promise((resolve, reject) => {
      const image = new Image(); image.decoding = 'async';
      image.onload = () => image.decode().catch(() => {}).then(() => resolve(image));
      image.onerror = reject; image.src = url;
    });
    photoCache.set(url, promise);
    if (photoCache.size > 50) photoCache.delete(photoCache.keys().next().value);
    promise.catch(() => photoCache.delete(url));
    return promise;
  }

  window.cGallery = (slides, autoplay = false, reveal = true) => ({
    images: slides.map(s => typeof s === 'string' ? s : matchMedia('(max-width: 767px)').matches ? s.small : s.large),
    fullImages: slides.map(s => typeof s === 'string' ? s : s.large),
    slots: ['', ''], frontSlot: 0, index: 0, startX: 0, startY: 0, inView: false,
    paused: false, focused: false, pausedByUser: reduced(), waiting: false, progress: 0,
    elapsed: 0, lastTick: 0, interval: null, observer: null, revealObserver: null, sequence: 0, isChanging: false, root: null,
    init() {
      this.root=this.$root; this.slots[0] = this.images[0] || '';
      if(autoplay&&reveal&&!reduced()){
        this.root.classList.add('c-reveal-wait');
        this.revealObserver=new IntersectionObserver(entries=>{if(entries[0].isIntersecting){this.root.classList.remove('c-reveal-wait');this.root.classList.add('c-reveal-done');this.revealObserver.disconnect();}},{threshold:.15});
        this.revealObserver.observe(this.root);
      }
      const warm = () => this.warmNext();
      this.observer = new IntersectionObserver(entries => {
        this.inView = entries[0].isIntersecting;
        if (this.inView) ('requestIdleCallback' in window) ? requestIdleCallback(warm,{timeout:1200}) : setTimeout(warm,300);
      },{rootMargin:'160px 0px',threshold:0.05});
      this.observer.observe(this.$el);
      if (autoplay && this.images.length>1) this.interval=setInterval(()=>this.tick(),100);
    },
    async warmNext() {
      if (!this.images.length || navigator.connection?.saveData || /(^|-)2g/.test(navigator.connection?.effectiveType || '')) return;
      try { await loadPhoto(this.images[(this.index+1)%this.images.length]); } catch (_) {}
    },
    async go(next) {
      if (!this.images.length) return;
      next=(next+this.images.length)%this.images.length;
      if (next===this.index && !this.isChanging) return;
      const sequence=++this.sequence, started=performance.now();
      this.isChanging=true;
      const waitingTimer=setTimeout(()=>{if(sequence===this.sequence)this.waiting=true;},180);
      try {
        await loadPhoto(this.images[next]);
        if(sequence!==this.sequence)return;
        const back=1-this.frontSlot;
        this.slots[back]=this.images[next];
        await this.$nextTick();
        requestAnimationFrame(()=>{
          if(sequence!==this.sequence)return;
          this.frontSlot=back; this.index=next; this.elapsed=0; this.progress=0;
          this.root.dataset.paintMs=Math.round(performance.now()-started);
          this.root.dataset.readyIndex=next;
          this.warmNext();
        });
      } catch (_) { this.root.dataset.photoError='true'; }
      finally { clearTimeout(waitingTimer); if(sequence===this.sequence){this.waiting=false;this.isChanging=false;} }
    },
    next() {this.go(this.index+1);}, prev() {this.go(this.index-1);},
    expand(title,trigger){window.dispatchEvent(new CustomEvent('open-c-gallery',{detail:{images:this.fullImages,index:this.index,title,trigger,rect:this.root.getBoundingClientRect().toJSON()}}));},
    tick() {
      const now=performance.now(), delta=this.lastTick ? Math.min(now-this.lastTick,200) : 100; this.lastTick=now;
      if(!this.inView||document.hidden||this.paused||this.focused||this.pausedByUser||reduced()||this.isChanging||document.documentElement.classList.contains('site-dialog-open'))return;
      this.elapsed+=delta; this.progress=Math.min(this.elapsed/6500,1);
      if(this.elapsed>=6500){this.elapsed=0;this.next();}
    },
    destroy(){this.observer?.disconnect();this.revealObserver?.disconnect();clearInterval(this.interval);++this.sequence;}
  });

  // One responsive MP4 is requested, never both. Muted autoplay follows browser policy.
  window.cHeroVideo=()=>({
    video:null,playing:false,muted:true,loading:false,failed:false,pausedByUser:false,
    inView:false,attached:false,environmentPause:false,observer:null,modalObserver:null,
    init(){
      this.video=this.$refs.film;this.video.muted=true;this.pausedByUser=reduced()||!!navigator.connection?.saveData;
      this.observer=new IntersectionObserver(entries=>{this.inView=entries[0].isIntersecting;this.sync();},{threshold:.12});this.observer.observe(this.video);
      this.modalObserver=new MutationObserver(()=>this.sync());this.modalObserver.observe(document.documentElement,{attributes:true,attributeFilter:['class']});
    },
    attach(){if(this.attached)return;const connection=navigator.connection;const light=matchMedia('(max-width:767px)').matches||connection?.saveData||['slow-2g','2g','3g'].includes(connection?.effectiveType)||(connection?.downlink>0&&connection.downlink<1.5);this.video.src=light?this.video.dataset.mobileSrc:this.video.dataset.desktopSrc;this.attached=true;this.loading=true;},
    async sync(){
      if(!this.video)return;const fullscreen=document.fullscreenElement===this.video;
      const shouldPlay=(this.inView||fullscreen)&&!document.hidden&&!document.documentElement.classList.contains('site-dialog-open')&&!this.pausedByUser&&!this.failed;
      this.environmentPause=!shouldPlay;if(!shouldPlay){this.video.pause();return;}
      this.attach();try{await this.video.play();}catch(_){this.playing=false;this.loading=false;}
    },
    onPlay(){this.playing=true;this.pausedByUser=false;},
    onPause(){this.playing=false;if(!this.environmentPause)this.pausedByUser=true;},
    resume(){this.pausedByUser=false;this.failed=false;this.sync();},
    holdForDialog(){this.environmentPause=true;this.video?.pause();},
    toggleSound(){this.video.muted=!this.video.muted;this.muted=this.video.muted;this.resume();},
    watch(){this.video.scrollIntoView({behavior:reduced()?'instant':'smooth',block:'center'});this.inView=true;this.video.muted=false;this.muted=false;this.resume();if(this.video.requestFullscreen)this.video.requestFullscreen().catch(()=>{});else this.video.webkitEnterFullscreen?.();},
    destroy(){this.observer?.disconnect();this.modalObserver?.disconnect();this.environmentPause=true;this.video?.pause();}
  });

  window.cCatalog = inventory => ({
    inventory,category:'condo',budget:'all',area:'all',limit:5,
    init(){['category','budget','area'].forEach(key=>this.$watch(key,()=>this.limit=5));this.$nextTick(()=>this.selectFromHash());},
    matches(price,area){return(this.area==='all'||area===this.area)&&(this.budget==='all'||price!==null&&((this.budget==='under5'&&price<5)||(this.budget==='5to10'&&price>=5&&price<=10)||(this.budget==='over10'&&price>10)));},
    filtered(){return this.inventory.filter(p=>p.category===this.category&&this.matches(p.price,p.area));},
    visibleCount(){return this.filtered().length;},
    isVisible(id){return this.filtered().slice(0,this.limit).some(p=>p.id===id);},
    more(){const from=this.limit;this.limit=Math.min(this.limit+5,this.visibleCount());this.$nextTick(()=>{const added=this.filtered().slice(from,this.limit);added.forEach((p,i)=>{const card=document.getElementById('project-'+p.id);if(card&&!reduced())card.animate([{opacity:0,transform:'translateY(20px)'},{opacity:1,transform:'translateY(0)'}],{duration:440,delay:i*70,easing:'cubic-bezier(.22,1,.36,1)',fill:'backwards'});});const first=document.getElementById('project-'+added[0]?.id);first?.focus({preventScroll:true});first?.scrollIntoView({behavior:reduced()?'instant':'smooth',block:'start'});});},
    fewer(){this.limit=5;this.$nextTick(()=>{const target=document.getElementById('projects'),heading=target?.querySelector('h2');heading?.setAttribute('tabindex','-1');heading?.focus({preventScroll:true});target?.scrollIntoView({behavior:reduced()?'instant':'smooth',block:'start'});});},
    select(category,target){this.category=category;this.budget='all';this.area='all';this.$nextTick(()=>this.reveal(target));},
    reveal(target){const id=Number(target.replace('project-','')),rank=this.filtered().findIndex(p=>p.id===id);if(rank<0)return;this.limit=Math.max(5,rank+1);this.$nextTick(()=>document.getElementById(target)?.scrollIntoView({behavior:reduced()?'instant':'smooth',block:'start'}));},
    selectFromHash(){const target=location.hash.slice(1);if(!/^project-\d+$/.test(target))return;const project=this.inventory.find(p=>p.id===Number(target.slice(8)));if(project)this.select(project.category,target);}
  });

  window.cRail = () => ({move(direction){const track=this.$refs.track,card=track.firstElementChild;track.scrollBy({left:direction*((card?.getBoundingClientRect().width||280)+24),behavior:reduced()?'instant':'smooth'});}});

  window.cLightbox=()=>({
    images:[],index:0,title:'',source:'',waiting:false,error:false,sequence:0,previousFocus:null,openingRect:null,startX:0,startY:0,closing:false,
    async show(detail){
      if(!detail.images?.length||this.$refs.panel.open)return;
      window.dispatchEvent(new CustomEvent('c-stop-previews'));
      this.images=detail.images;this.index=detail.index||0;this.title=detail.title;this.previousFocus=detail.trigger;this.openingRect=detail.rect;this.source='';this.error=false;this.closing=false;
      this.$refs.panel.showModal();document.documentElement.classList.add('site-dialog-open');this.$refs.close.focus({preventScroll:true});await this.go(this.index,true);
    },
    async go(next,enter=false){
      next=(next+this.images.length)%this.images.length;const sequence=++this.sequence;this.waiting=true;this.error=false;
      try{await loadPhoto(this.images[next]);if(sequence!==this.sequence||!this.$refs.panel.open)return;
        this.source=this.images[next];this.index=next;await this.$nextTick();await this.$refs.photo.decode().catch(()=>{});
        if(sequence!==this.sequence||!this.$refs.panel.open)return;
        const photo=this.$refs.photo;
        if(!reduced()){
          const to=photo.getBoundingClientRect(),from=this.openingRect;
          if(enter&&from?.width&&to.width)photo.animate([{transformOrigin:'0 0',transform:`translate(${from.x-to.x}px,${from.y-to.y}px) scale(${from.width/to.width},${from.height/to.height})`,opacity:.6},{transformOrigin:'0 0',transform:'none',opacity:1}],{duration:460,easing:'cubic-bezier(.22,1,.36,1)'});
          else photo.animate([{opacity:.25,transform:'translateX(12px)'},{opacity:1,transform:'none'}],{duration:240,easing:'ease-out'});
        }
        if(!navigator.connection?.saveData)loadPhoto(this.images[(next+1)%this.images.length]).catch(()=>{});
      }catch(_){if(sequence===this.sequence)this.error=true;}finally{if(sequence===this.sequence)this.waiting=false;}
    },
    async close(){if(!this.$refs.panel.open||this.closing)return;this.closing=true;++this.sequence;
      if(!reduced())await this.$refs.panel.animate([{opacity:1},{opacity:0}],{duration:140}).finished.catch(()=>{});
      this.$refs.panel.close();document.documentElement.classList.remove('site-dialog-open');this.source='';this.waiting=false;this.previousFocus?.focus({preventScroll:true});this.closing=false;
    },
    trap(e){const buttons=[...this.$refs.panel.querySelectorAll('button')].filter(el=>el.getClientRects().length&&!el.disabled),first=buttons[0],last=buttons.at(-1);if(!first)return;if(e.shiftKey&&(document.activeElement===first||document.activeElement===this.$refs.panel)){e.preventDefault();last.focus();}else if(!e.shiftKey&&document.activeElement===last){e.preventDefault();first.focus();}},
    swipe(e){const dx=e.changedTouches[0].clientX-this.startX,dy=e.changedTouches[0].clientY-this.startY;if(Math.abs(dx)>45&&Math.abs(dx)>Math.abs(dy))this.go(this.index+(dx<0?1:-1));}
  });

  let youtubeApi=null;
  function loadYoutube(){
    if(window.YT?.Player)return Promise.resolve();
    if(!youtubeApi)youtubeApi=new Promise((resolve,reject)=>{
      const previous=window.onYouTubeIframeAPIReady;
      window.onYouTubeIframeAPIReady=()=>{previous?.();resolve();};
      const script=document.createElement('script');script.src='https://www.youtube.com/iframe_api';script.async=true;
      script.onerror=()=>{script.remove();youtubeApi=null;reject(new Error('Video preview unavailable'));};document.head.append(script);
    });
    return youtubeApi;
  }
  // YouTube player parameters: https://developers.google.com/youtube/player_parameters
  window.cVideoPreview=(embed,title)=>({
    embed,title,active:false,playing:false,failed:false,player:null,timer:null,hoverTimer:null,deadline:null,sequence:0,observer:null,
    init(){this.observer=new IntersectionObserver(entries=>{if(!entries[0].isIntersecting)this.stop();});this.observer.observe(this.$root);},
    hover(){if(reduced()||navigator.connection?.saveData||!matchMedia('(hover:hover) and (pointer:fine)').matches)return;this.hoverTimer=setTimeout(()=>this.start(),450);},
    async start(){
      if(this.active)return;if(!/https:\/\/www\.youtube-nocookie\.com\/embed\/[\w-]{11}$/.test(this.embed||'')){this.failed=true;return;}
      window.dispatchEvent(new CustomEvent('c-stop-previews'));const sequence=++this.sequence;this.active=true;this.failed=false;
      this.deadline=setTimeout(()=>{if(!this.playing){this.stop();this.failed=true;}},15000);
      try{await loadYoutube();if(sequence!==this.sequence)return;
        const host=document.createElement('div');this.$refs.preview.replaceChildren(host);
        this.player=new YT.Player(host,{host:'https://www.youtube-nocookie.com',videoId:this.embed.split('/').pop(),width:'100%',height:'100%',playerVars:{autoplay:0,controls:0,playsinline:1,disablekb:1,fs:0,rel:0,origin:location.origin,end:3},events:{
          onReady:event=>{if(sequence!==this.sequence){event.target.destroy();return;}event.target.getIframe().tabIndex=-1;event.target.getIframe().title=this.title;event.target.mute();event.target.playVideo();},
          onStateChange:event=>{if(sequence!==this.sequence)return;if(event.data===1&&!this.playing){this.playing=true;clearTimeout(this.deadline);this.timer=setTimeout(()=>this.stop(),3200);}if(event.data===0)this.stop();},
          onError:()=>{if(sequence===this.sequence){this.stop();this.failed=true;}}
        }});
      }catch(_){if(sequence===this.sequence){this.stop();this.failed=true;}}
    },
    stop(){clearTimeout(this.hoverTimer);clearTimeout(this.timer);clearTimeout(this.deadline);++this.sequence;this.player?.destroy();this.player=null;this.$refs.preview?.replaceChildren();this.active=false;this.playing=false;},
    destroy(){this.stop();this.observer?.disconnect();}
  });

  window.cIntent=()=>({
    selected:'',timer:null,frame:null,journey:0,
    choose(purpose){
      this.selected=purpose;window.dispatchEvent(new CustomEvent('intent-selected',{detail:{purpose}}));
      const target=document.getElementById(purpose==='living'?'projects':'invest2');if(!target)return;
      document.querySelectorAll('.c-intent-arrival').forEach(el=>el.classList.remove('c-intent-arrival'));
      const heading=target.querySelector('h2');heading?.setAttribute('tabindex','-1');heading?.focus({preventScroll:true});target.scrollIntoView({behavior:reduced()?'instant':'smooth',block:'start'});
      clearTimeout(this.timer);cancelAnimationFrame(this.frame);const journey=++this.journey,started=performance.now();let lastY=-1,still=0;
      const markArrival=()=>{if(journey!==this.journey)return;const y=scrollY;still=Math.abs(y-lastY)<1?still+1:0;lastY=y;
        if(reduced()||(performance.now()-started>200&&still>5)||performance.now()-started>2500){target.classList.add('c-intent-arrival');this.timer=setTimeout(()=>target.classList.remove('c-intent-arrival'),1600);}
        else this.frame=requestAnimationFrame(markArrival);
      };this.frame=requestAnimationFrame(markArrival);
    },destroy(){clearTimeout(this.timer);cancelAnimationFrame(this.frame);++this.journey;}
  });

  const offerKey='sanbada-offer-seen';
  const offerSeen=()=>{try{return sessionStorage.getItem(offerKey)==='1';}catch(_){return false;}};
  const setOfferSeen=()=>{try{sessionStorage.setItem(offerKey,'1');}catch(_){}};
  window.cOffer = () => ({
    open:false,previousFocus:null,timer:null,
    init(){this.timer=setTimeout(()=>{if(!offerSeen()&&!document.hidden&&!document.activeElement?.matches('input,textarea,select')&&!document.documentElement.classList.contains('site-dialog-open'))this.show();},12000);if(new URLSearchParams(location.search).has('offer'))this.$nextTick(()=>this.show(true));},
    show(manual=false){if(this.open||(!manual&&offerSeen())||document.documentElement.classList.contains('site-dialog-open'))return;window.dispatchEvent(new CustomEvent('c-stop-previews'));this.previousFocus=document.activeElement;this.open=true;setOfferSeen();document.documentElement.classList.add('site-dialog-open');this.$nextTick(()=>this.$refs.close.focus({preventScroll:true}));},
    close(){if(!this.open)return;this.open=false;document.documentElement.classList.remove('site-dialog-open');this.previousFocus?.focus({preventScroll:true});},
    accept(){this.close();setTimeout(()=>window.dispatchEvent(new CustomEvent('open-lead',{detail:{}})),120);},
    trap(e){if(!this.open||e.key!=='Tab')return;const focusable=[...this.$el.querySelectorAll('a[href],button')].filter(el=>el.getClientRects().length),first=focusable[0],last=focusable.at(-1);if(e.shiftKey&&document.activeElement===first){e.preventDefault();last.focus();}else if(!e.shiftKey&&document.activeElement===last){e.preventDefault();first.focus();}},
    destroy(){clearTimeout(this.timer);}
  });

  let quizLoad=null;
  window.cOpenQuiz = async button => {
    const original=button.innerHTML;button.disabled=true;
    try{
      if(!quizLoad)quizLoad=new Promise((resolve,reject)=>{const script=document.createElement('script');script.src='https://script.marquiz.ru/v2.js';script.async=true;script.onload=()=>{window.Marquiz.init({host:'https://quiz.marquiz.ru',region:'ru',id:'694f90aa56ae670019803ad9',autoOpen:false,autoOpenFreq:'once',openOnExit:false,disableOnMobile:false});resolve();};script.onerror=()=>{quizLoad=null;reject();};document.head.append(script);});
      await quizLoad;window.Marquiz.showModal('694f90aa56ae670019803ad9');
    }catch(_){button.textContent=document.documentElement.lang==='ru'?'Повторить загрузку квиза':'Try loading the quiz again';}
    finally{button.disabled=false;if(window.Marquiz)button.innerHTML=original;}
  };
})();
