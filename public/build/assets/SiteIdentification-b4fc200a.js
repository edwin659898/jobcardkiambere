import{B as y}from"./Authenticated-6f933b77.js";import{H as w,L as k,U as f,q as c,o as n,g as i,a as m,w as S,F as u,d as e,t as o,k as _,f as h,h as j,x as B,n as C,s as b}from"./app-7d6d683b.js";import{_ as N}from"./Record-edaaab17.js";import{Z as J}from"./main-18b6a265.js";import{_ as D}from"./_plugin-vue_export-helper-c27b6911.js";const V={components:{BreezeAuthenticatedLayout:y,Head:w,Link:k,Datepicker:J,Record:N},props:{Jobcard:Object,success:String,BeginDate:String,Name:String,Users:Object},data(){return{form:this.$inertia.form({start_date:this.$props.BeginDate,compartment_name:"",type:this.$props.Name})}},methods:{update(a){this.form.patch(`/seed-bed-preparation/identify-point-of-sand-collection/${a}`,{onSuccess:()=>{this.form.item_name=""},preserveScroll:!0})},complete(a){f.Inertia.get(route("complete.labelling",a))},destroy(a){confirm("Are you sure you want to remove")&&f.Inertia.delete(route("destroy.compartment",a))}}},L={class:"content-wrapper"},A=e("div",{class:"content-header"},[e("div",{class:"container-fluid"},[e("div",{class:"row mb-2"},[e("div",{class:"col-sm-6"},[e("h1",{class:"m-0"}," Job Card for Mukau Production ")]),e("div",{class:"col-sm-6"},[e("ol",{class:"breadcrumb float-sm-right"},[e("li",{class:"breadcrumb-item"},"Home"),e("li",{class:"breadcrumb-item active"},"job-card ")])])])])],-1),H={class:"content"},z={class:"container-fluid text-sm"},P={class:"row"},U={class:"col-lg-12 connectedSortable"},I={class:"py-6"},M={class:"max-w-7xl mx-auto sm:px-6 lg:px-8"},O={class:"bg-white overflow-hidden shadow-sm sm:rounded-lg"},q={class:"p-4 bg-white border-b border-gray-200"},F={class:"card-header flex justify-between"},R=e("h3",{class:"card-title"},"Job Card Review",-1),T={class:"card-body"},Z={key:0,class:"p-2 mb-1 text-sm text-blue-700 bg-blue-100 rounded-lg",role:"alert"},E={class:"col-sm-12 pt-8"},G={class:"form-group"},K={key:0,class:"text-xs text-red-600 mt-2"},Q={class:"form-group flex items-center justify-between space-x-2"},W={class:"w-full"},X=["placeholder"],Y={key:0,class:"text-xs text-red-600 mt-2"},$={class:"flex justify-end"},ee=["disabled"],te={class:"table-responsive"},se={class:"table table-hover text-nowrap mt-6"},oe=e("th",null,"No",-1),re=["onClick"],ne={class:"flex flex-col justify-between pt-12"},ie={class:"flex justify-center"},ae={class:"block bg-white max-w-sm text-center"},de=e("div",{class:"py-2 px-6 border-b border-gray-300"}," Signature ",-1),le={class:"p-6"},ce=e("p",{class:"text-gray-700 text-xs mb-4"}," Persons to sign ",-1),me={class:"mt-2 text-sm font-bold"},ue={class:"flex justify-end mt-4"};function _e(a,r,d,pe,s,l){const v=c("Head"),x=c("Datepicker"),g=c("BreezeAuthenticatedLayout");return n(),i(u,null,[m(v,{title:"Operational Planning"}),m(g,null,{default:S(()=>[e("div",L,[A,e("section",H,[e("div",z,[e("div",P,[e("section",U,[e("div",I,[e("div",M,[e("div",O,[e("div",q,[e("div",F,[R,e("p",null,"Site: "+o(d.Jobcard.site),1)]),e("div",T,[d.success?(n(),i("div",Z,o(d.success),1)):_("",!0),e("form",{onSubmit:r[3]||(r[3]=h(t=>l.update(d.Jobcard.id),["prevent"]))},[e("div",E,[e("div",G,[e("label",null,o(a.$page.props.ActivityTitle),1),m(x,{modelValue:s.form.start_date,"onUpdate:modelValue":r[0]||(r[0]=t=>s.form.start_date=t),position:"left",altPosition:""},null,8,["modelValue"]),s.form.errors.start_date?(n(),i("p",K,o(s.form.errors.start_date),1)):_("",!0)]),e("div",Q,[e("div",W,[j(e("input",{type:"text","onUpdate:modelValue":r[1]||(r[1]=t=>s.form.compartment_name=t),placeholder:this.$props.Name,required:"",class:"w-full py-1 text-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"},null,8,X),[[B,s.form.compartment_name]]),s.form.errors.compartment_name?(n(),i("p",Y,o(s.form.errors.compartment_name),1)):_("",!0)])]),e("div",$,[e("button",{class:C([{"opacity-25":s.form.processing},"inline-flex justify-center rounded-md border border-transparent px-3 py-1 bg-blue-600 text-base leading-6 font-medium text-white shadow-sm hover:bg-blue-500 focus:outline-none focus:border-blue-700 focus:shadow-outline-blue transition ease-in-out duration-150 sm:text-sm sm:leading-5"]),disabled:s.form.processing}," Save ",10,ee)]),e("div",te,[e("table",se,[e("thead",null,[e("tr",null,[oe,e("th",null,"Name of "+o(this.$props.Name),1)])]),e("tbody",null,[(n(!0),i(u,null,b(d.Jobcard.bed_prep,(t,p)=>(n(),i("tr",{key:p},[e("td",null,o(p+1),1),e("td",null,o(t.name),1),e("td",null,[e("i",{onClick:fe=>l.destroy(t.id),class:"fas fa-trash cursor-pointer text-red-500 hover:text-red-800"},null,8,re)])]))),128))])])]),e("div",ne,[e("div",ie,[e("div",ae,[de,e("div",le,[ce,(n(!0),i(u,null,b(d.Jobcard.childactivity.roles,t=>(n(),i("div",{key:t.id,class:"flex items-center space-x-1"},[e("p",me,o(t.role),1)]))),128))])])])]),e("div",ue,[e("button",{onClick:r[2]||(r[2]=h(t=>l.complete(d.Jobcard.id),["prevent"])),class:"inline-flex justify-center rounded-md border border-transparent px-4 py-2 bg-green-600 text-base leading-6 font-medium text-white shadow-sm hover:bg-green-500 focus:outline-none focus:border-green-700 focus:shadow-outline-green transition ease-in-out duration-150 sm:text-sm sm:leading-5"},"Sign and Save")])])],32)])])])])])])])])])])]),_:1})],64)}const ye=D(V,[["render",_e]]);export{ye as default};
