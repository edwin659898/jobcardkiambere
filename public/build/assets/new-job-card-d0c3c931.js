import{B as k}from"./Authenticated-6f933b77.js";import{H as w,L as j,q as _,o as r,g as i,a as m,w as N,F as u,d as e,t as n,f as V,h as l,V as L,k as c,x as f,s as b,m as x}from"./app-7d6d683b.js";import{Z as C}from"./main-18b6a265.js";import{_ as S}from"./_plugin-vue_export-helper-c27b6911.js";const D={components:{BreezeAuthenticatedLayout:k,Head:w,Link:j,Datepicker:C},props:{Activity:Object,value:{type:String,default:""}},data(){return{form:this.$inertia.form({start_date:null,site:null,projectName:"",locations:[],records:[],signature:[],current_child_id:this.$props.Activity.id,current_parent_id:this.$props.Activity.parent_activity_id}),recordLocations:[]}},methods:{submit(){this.form.locations=this.recordLocations.filter(a=>a),this.form.post("/New-Jobcard")}}},A={class:"content-wrapper"},B={class:"content-header"},U={class:"container-fluid"},H={class:"row mb-2"},z={class:"col-sm-6"},F={class:"m-0"},M={class:"col-sm-6"},q={class:"breadcrumb float-sm-right"},J=e("li",{class:"breadcrumb-item"},"Home",-1),O={class:"breadcrumb-item active"},P={class:"content"},G={class:"container-fluid"},I={class:"row"},K={class:"col-lg-12 connectedSortable"},Z={class:"py-6"},E={class:"max-w-7xl mx-auto sm:px-6 lg:px-8"},R={class:"bg-white overflow-hidden shadow-sm sm:rounded-lg"},T={class:"p-4 bg-white border-b border-gray-200"},Q=e("div",{class:"card-header"},[e("h3",{class:"card-title"},"New Job Card")],-1),W={class:"card-body"},X={class:"row"},Y={class:"col-sm-12"},$={class:"form-group"},ee=e("label",{for:"site"},"Site:",-1),te=e("option",{selected:""},"-- Choose a site --",-1),se=e("option",{value:"Kiambere"},"Kiambere",-1),oe=e("option",{value:"Nyongoro"},"Nyongoro",-1),re=e("option",{value:"7 Forks"},"7 Forks",-1),ie=e("option",{value:"GIC"},"GIC",-1),ne=[te,se,oe,re,ie],ce={key:0,class:"text-xs text-red-600 mt-1"},de={class:"form-group"},le=e("label",{for:"site"},"Project Name:",-1),ae={key:0,class:"text-xs text-red-600 mt-1"},_e={class:"form-group"},me=e("label",null,"Determination of Objectives Start Date:",-1),ue={key:0,class:"text-xs text-red-600 mt-2"},pe={class:"flex justify-center"},he={class:"block bg-white text-center"},fe=e("div",{class:"py-3 px-6 border-b border-gray-300"}," Documents Required ",-1),be={key:0,class:"text-xs text-red-600 mt-2"},xe={key:1,class:"text-xs text-red-600 mt-2"},ve={class:"p-6"},ge=e("p",{class:"text-gray-700 text-xs mb-4"}," Check the documents to confirm all are available ",-1),ye={class:"flex items-center space-x-1"},ke=["value"],we={class:"mt-2 text-sm font-bold"},je=["onUpdate:modelValue"],Ne={class:"flex justify-center"},Ve={class:"block bg-white max-w-sm text-center"},Le=e("div",{class:"py-2 px-6 border-b border-gray-300"}," Signature ",-1),Ce={key:0,class:"text-xs text-red-600 mt-2"},Se={class:"p-6"},De=e("p",{class:"text-gray-700 text-xs mb-4"}," Sign to confirm below that you approve document ",-1),Ae=["value"],Be={class:"mt-2 text-sm font-bold"},Ue=e("div",{class:"flex justify-end mt-4"},[e("button",{class:"inline-flex justify-center rounded-md border border-transparent px-4 py-2 bg-green-600 text-base leading-6 font-medium text-white shadow-sm hover:bg-green-500 focus:outline-none focus:border-green-700 focus:shadow-outline-green transition ease-in-out duration-150 sm:text-sm sm:leading-5"},"Save")],-1);function He(a,o,p,ze,t,h){const v=_("Head"),g=_("Datepicker"),y=_("BreezeAuthenticatedLayout");return r(),i(u,null,[m(v,{title:"Operational Planning"}),m(y,null,{default:N(()=>[e("div",A,[e("div",B,[e("div",U,[e("div",H,[e("div",z,[e("h1",F,n(a.route().current()),1)]),e("div",M,[e("ol",q,[J,e("li",O,n(a.route().current()),1)])])])])]),e("section",P,[e("div",G,[e("div",I,[e("section",K,[e("div",Z,[e("div",E,[e("div",R,[e("div",T,[Q,e("div",W,[e("form",{onSubmit:o[5]||(o[5]=V((...s)=>h.submit&&h.submit(...s),["prevent"]))},[e("div",X,[e("div",Y,[e("div",$,[ee,l(e("select",{id:"site","onUpdate:modelValue":o[0]||(o[0]=s=>t.form.site=s),required:"",class:"block p-2 w-full text-sm rounded-lg border border-gray-300 focus:ring-gray-200 focus:border-gray-200"},ne,512),[[L,t.form.site]]),t.form.errors.site?(r(),i("p",ce,n(t.form.errors.site),1)):c("",!0)]),e("div",de,[le,l(e("input",{type:"text","onUpdate:modelValue":o[1]||(o[1]=s=>t.form.projectName=s),class:"block p-2 w-full text-sm rounded-lg border border-gray-300 focus:ring-gray-200 focus:border-gray-200"},null,512),[[f,t.form.projectName]]),t.form.errors.projectNamee?(r(),i("p",ae,n(t.form.errors.projectName),1)):c("",!0)]),e("div",_e,[me,m(g,{modelValue:t.form.start_date,"onUpdate:modelValue":o[2]||(o[2]=s=>t.form.start_date=s),position:"left",altPosition:""},null,8,["modelValue"]),t.form.errors.start_date?(r(),i("p",ue,n(t.form.errors.start_date),1)):c("",!0)]),e("div",pe,[e("div",he,[fe,t.form.errors.records?(r(),i("p",be,n(t.form.errors.records),1)):c("",!0),t.form.errors.locations?(r(),i("p",xe,n(t.form.errors.locations),1)):c("",!0),e("div",ve,[ge,(r(!0),i(u,null,b(p.Activity.records,s=>(r(),i("div",{key:s.id,class:"flex justify-between space-x-2"},[e("div",ye,[l(e("input",{type:"checkbox","onUpdate:modelValue":o[3]||(o[3]=d=>t.form.records=d),value:s.id,class:"text-red-600 rounded-md focus:ring-0"},null,8,ke),[[x,t.form.records]]),e("label",we,n(s.record),1)]),l(e("input",{type:"text","onUpdate:modelValue":d=>t.recordLocations[s.id]=d,class:"block mt-1 border border-gray-300 rounded-lg bg-gray-50 sm:text-xs focus:ring-blue-500 focus:border-blue-500",placeholder:"Document Location"},null,8,je),[[f,t.recordLocations[s.id],void 0,{lazy:!0}]])]))),128))])])]),e("div",Ne,[e("div",Ve,[Le,t.form.errors.signature?(r(),i("p",Ce,n(t.form.errors.signature),1)):c("",!0),e("div",Se,[De,(r(!0),i(u,null,b(p.Activity.roles,s=>(r(),i("div",{key:s.id,class:"flex items-center space-x-1"},[l(e("input",{type:"checkbox","onUpdate:modelValue":o[4]||(o[4]=d=>t.form.signature=d),value:s.id,class:"text-green-600 rounded-md focus:ring-0"},null,8,Ae),[[x,t.form.signature]]),e("label",Be,n(s.role),1)]))),128))])])]),Ue])])],32)])])])])])])])])])])]),_:1})],64)}const Oe=S(D,[["render",He]]);export{Oe as default};
