import{B as w}from"./Authenticated-6ca149e0.js";import{H as M,L as S,q as u,o as r,g as i,a as _,w as D,F as m,d as e,t as n,f as A,h as a,V as h,k as d,x as g,s as b,m as v}from"./app-c03fa087.js";import{Z as F}from"./main-9361634d.js";import{_ as V}from"./_plugin-vue_export-helper-c27b6911.js";const j={components:{BreezeAuthenticatedLayout:w,Head:M,Link:S,Datepicker:F},props:{Activity:Object,value:{type:String,default:""}},data(){return{form:this.$inertia.form({start_date:null,site:null,projectName:"",locations:[],records:[],signature:[],current_child_id:this.$props.Activity.id,current_parent_id:this.$props.Activity.parent_activity_id}),recordLocations:[]}},methods:{submit(){this.form.locations=this.recordLocations.filter(l=>l),this.form.post("/New-Jobcard")}}},N={class:"content-wrapper"},C={class:"content-header"},L={class:"container-fluid"},B={class:"row mb-2"},U={class:"col-sm-6"},E={class:"m-0"},O={class:"col-sm-6"},H={class:"breadcrumb float-sm-right"},q=e("li",{class:"breadcrumb-item"},"Home",-1),z={class:"breadcrumb-item active"},I={class:"content"},J={class:"container-fluid"},P={class:"row"},G={class:"col-lg-12 connectedSortable"},K={class:"py-6"},T={class:"max-w-7xl mx-auto sm:px-6 lg:px-8"},Z={class:"bg-white overflow-hidden shadow-sm sm:rounded-lg"},R={class:"p-4 bg-white border-b border-gray-200"},Q=e("div",{class:"card-header"},[e("h3",{class:"card-title"},"New Job Card")],-1),W={class:"card-body"},X={class:"row"},Y={class:"col-sm-12"},$={class:"form-group"},ee=e("label",{for:"site"},"Site:",-1),te=e("option",{selected:""},"-- Choose a site --",-1),oe=e("option",{value:"Kiambere"},"Kiambere",-1),se=e("option",{value:"Nyongoro"},"Nyongoro",-1),re=e("option",{value:"7 Forks"},"7 Forks",-1),ie=e("option",{value:"GIC"},"GIC",-1),ne=[te,oe,se,re,ie],ce={key:0,class:"text-xs text-red-600 mt-1"},ae={class:"form-group"},de=e("label",{for:"site"},"Project Name:",-1),le={key:0,class:"text-xs text-red-600 mt-1"},ue={class:"form-group"},_e=e("label",null,"Determination of Objectives Start Date:",-1),me={key:0,class:"text-xs text-red-600 mt-2"},pe={class:"flex justify-center"},fe={class:"block bg-white text-center"},he=e("div",{class:"py-3 px-6 border-b border-gray-300"}," Documents Required ",-1),ge={key:0,class:"text-xs text-red-600 mt-2"},be={key:1,class:"text-xs text-red-600 mt-2"},ve={class:"p-6"},xe=e("p",{class:"text-gray-700 text-xs mb-4"}," Check the documents to confirm all are available ",-1),ye={class:"flex items-center space-x-1"},ke=["value"],we={class:"mt-2 text-sm font-bold"},Me=["onUpdate:modelValue"],Se={class:"flex justify-center"},De={class:"block bg-white max-w-sm text-center"},Ae=e("div",{class:"py-2 px-6 border-b border-gray-300"}," Signature ",-1),Fe={key:0,class:"text-xs text-red-600 mt-2"},Ve={class:"p-6"},je=e("p",{class:"text-gray-700 text-xs mb-4"}," Sign to confirm below that you approve document ",-1),Ne=["value"],Ce={class:"mt-2 text-sm font-bold"},Le=e("option",{value:"Managing Director"},"Managing Director",-1),Be=e("option",{value:"Executive Director Forestry"},"Executive Director Forestry",-1),Ue=e("option",{value:"System & Administration Manager"},"System & Administration Manager",-1),Ee=e("option",{value:"Site Managr Dokolo"},"Site Managr Dokolo",-1),Oe=e("option",{value:"Site Manager Farmers program 7 F"},"Site Manager Farmers program 7 F",-1),He=e("option",{value:"Farmers BO & Contracting Manager"},"Farmers BO & Contracting Manager",-1),qe=e("option",{value:"Monitoring and Evaluation Manager"},"Monitoring and Evaluation Manager",-1),ze=e("option",{value:"Monitoring and Evaluation Officer"},"Monitoring and Evaluation Officer",-1),Ie=e("option",{value:"Information & Security officer"},"Information & Security officer",-1),Je=e("option",{value:"Agro-Forestry Agents"},"Agro-Forestry Agents",-1),Pe=[Le,Be,Ue,Ee,Oe,He,qe,ze,Ie,Je],Ge=e("div",{class:"flex justify-end mt-4"},[e("button",{class:"inline-flex justify-center rounded-md border border-transparent px-4 py-2 bg-green-600 text-base leading-6 font-medium text-white shadow-sm hover:bg-green-500 focus:outline-none focus:border-green-700 focus:shadow-outline-green transition ease-in-out duration-150 sm:text-sm sm:leading-5"},"Save")],-1);function Ke(l,s,p,Te,t,f){const x=u("Head"),y=u("Datepicker"),k=u("BreezeAuthenticatedLayout");return r(),i(m,null,[_(x,{title:"Operational Planning"}),_(k,null,{default:D(()=>[e("div",N,[e("div",C,[e("div",L,[e("div",B,[e("div",U,[e("h1",E,n(l.route().current()),1)]),e("div",O,[e("ol",H,[q,e("li",z,n(l.route().current()),1)])])])])]),e("section",I,[e("div",J,[e("div",P,[e("section",G,[e("div",K,[e("div",T,[e("div",Z,[e("div",R,[Q,e("div",W,[e("form",{onSubmit:s[6]||(s[6]=A((...o)=>f.submit&&f.submit(...o),["prevent"]))},[e("div",X,[e("div",Y,[e("div",$,[ee,a(e("select",{id:"site","onUpdate:modelValue":s[0]||(s[0]=o=>t.form.site=o),required:"",class:"block p-2 w-full text-sm rounded-lg border border-gray-300 focus:ring-gray-200 focus:border-gray-200"},ne,512),[[h,t.form.site]]),t.form.errors.site?(r(),i("p",ce,n(t.form.errors.site),1)):d("",!0)]),e("div",ae,[de,a(e("input",{type:"text","onUpdate:modelValue":s[1]||(s[1]=o=>t.form.projectName=o),class:"block p-2 w-full text-sm rounded-lg border border-gray-300 focus:ring-gray-200 focus:border-gray-200"},null,512),[[g,t.form.projectName]]),t.form.errors.projectNamee?(r(),i("p",le,n(t.form.errors.projectName),1)):d("",!0)]),e("div",ue,[_e,_(y,{modelValue:t.form.start_date,"onUpdate:modelValue":s[2]||(s[2]=o=>t.form.start_date=o),position:"left",altPosition:""},null,8,["modelValue"]),t.form.errors.start_date?(r(),i("p",me,n(t.form.errors.start_date),1)):d("",!0)]),e("div",pe,[e("div",fe,[he,t.form.errors.records?(r(),i("p",ge,n(t.form.errors.records),1)):d("",!0),t.form.errors.locations?(r(),i("p",be,n(t.form.errors.locations),1)):d("",!0),e("div",ve,[xe,(r(!0),i(m,null,b(p.Activity.records,o=>(r(),i("div",{key:o.id,class:"flex justify-between space-x-2"},[e("div",ye,[a(e("input",{type:"checkbox","onUpdate:modelValue":s[3]||(s[3]=c=>t.form.records=c),value:o.id,class:"text-red-600 rounded-md focus:ring-0"},null,8,ke),[[v,t.form.records]]),e("label",we,n(o.record),1)]),a(e("input",{type:"text","onUpdate:modelValue":c=>t.recordLocations[o.id]=c,class:"block mt-1 border border-gray-300 rounded-lg bg-gray-50 sm:text-xs focus:ring-blue-500 focus:border-blue-500",placeholder:"Document Location"},null,8,Me),[[g,t.recordLocations[o.id],void 0,{lazy:!0}]])]))),128))])])]),e("div",Se,[e("div",De,[Ae,t.form.errors.signature?(r(),i("p",Fe,n(t.form.errors.signature),1)):d("",!0),e("div",Ve,[je,(r(!0),i(m,null,b(p.Activity.roles,o=>(r(),i("div",{key:o.id,class:"flex items-center space-x-1"},[a(e("input",{type:"checkbox","onUpdate:modelValue":s[4]||(s[4]=c=>t.form.signature=c),value:o.id,class:"text-green-600 rounded-md focus:ring-0"},null,8,Ne),[[v,t.form.signature]]),e("label",Ce,n(o.role),1),a(e("select",{"onUpdate:modelValue":s[5]||(s[5]=c=>t.form.site=c),class:"border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5",placeholder:"Select your role and Tick the box",required:""},Pe,512),[[h,t.form.site]])]))),128))])])]),Ge])])],32)])])])])])])])])])])]),_:1})],64)}const Xe=V(j,[["render",Ke]]);export{Xe as default};
