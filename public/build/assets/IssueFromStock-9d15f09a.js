import{B as S}from"./Authenticated-6f933b77.js";import{H as C,L as j,U as h,q as m,o,g as n,a as f,w as D,F as b,d as e,t as l,k as u,h as I,x as q,f as p,n as g,s as y}from"./app-7d6d683b.js";import{_ as B}from"./Record-edaaab17.js";import{Z as O}from"./main-18b6a265.js";import{s as V}from"./vue-multiselect.esm-22442a0d.js";import{_ as J}from"./_plugin-vue_export-helper-c27b6911.js";const N={components:{BreezeAuthenticatedLayout:S,Head:C,Link:j,Datepicker:O,Record:B,VueMultiselect:V},props:{Jobcard:Object,Users:Object,BeginDate:String,success:String},data(){return{form:this.$inertia.form({quantity:null,SelectedId:null,type:""}),SelectedOne:!1,start_date:this.$props.BeginDate}},methods:{issue(){this.form.patch(`/Depulping/store-quantity/${this.form.SelectedId}`,{onSuccess:()=>this.SelectedOne=!1,preserveScroll:!0})},receive(){this.form.patch(`/seed-extraction/receive-quantity/${this.form.SelectedId}`,{onSuccess:()=>this.SelectedOne=!1,preserveScroll:!0})},complete(r){h.Inertia.get(route("complete.labelling",r))},destroy(r){confirm("Are you sure you want to remove")&&h.Inertia.delete(route("destroy.stockIssue",r))},selected(r,t){this.form.quantity=null,this.SelectedOne=!0,this.form.SelectedId=r,this.form.type=t},format_date(r){if(r)return moment(String(r)).format("DD-MM-YYYY")}}},A={class:"content-wrapper"},L=e("div",{class:"content-header"},[e("div",{class:"container-fluid"},[e("div",{class:"row mb-2"},[e("div",{class:"col-sm-6"},[e("h1",{class:"m-0"}," Job Card for Mukau Production ")]),e("div",{class:"col-sm-6"},[e("ol",{class:"breadcrumb float-sm-right"},[e("li",{class:"breadcrumb-item"},"Home"),e("li",{class:"breadcrumb-item active"},"job-card ")])])])])],-1),M={class:"content"},H={class:"container-fluid text-sm"},z={class:"row"},P={class:"col-lg-12 connectedSortable"},R={class:"py-6"},U={class:"max-w-7xl mx-auto sm:px-6 lg:px-8"},Y={class:"bg-white overflow-hidden shadow-sm sm:rounded-lg"},F={class:"p-4 bg-white border-b border-gray-200"},T={class:"card-header flex justify-between"},Q=e("h3",{class:"card-title"},"Job Card Review",-1),Z={class:"card-body"},E={key:0,class:"p-2 mb-1 text-sm text-blue-700 bg-blue-100 rounded-lg",role:"alert"},G={class:"col-sm-12 pt-8"},K={class:"form-group"},W={class:"flex flex-col rounded-md shadow-lg px-3 py-2 pt-3"},X={key:0,class:"flex items-center justify-between space-x-2"},$=["disabled"],ee=["disabled"],te={key:1,class:"text-xs text-red-600 mt-2"},se={class:"table table-hover text-nowrap mt-6"},oe=e("thead",null,[e("tr",null,[e("th",null,"No"),e("th",null,"Tree Number"),e("th",null,"Quantity Issued(No)"),e("th",null,"Action")])],-1),ne={class:"flex justify-between items-center space-x-3 mt-2"},re=["onClick"],ie=["onClick"],le={class:"flex justify-end mt-4"};function de(r,t,d,ae,s,a){const v=m("Head"),x=m("Datepicker"),w=m("BreezeAuthenticatedLayout");return o(),n(b,null,[f(v,{title:"Operational Planning"}),f(w,null,{default:D(()=>[e("div",A,[L,e("section",M,[e("div",H,[e("div",z,[e("section",P,[e("div",R,[e("div",U,[e("div",Y,[e("div",F,[e("div",T,[Q,e("p",null,"Card No: "+l(d.Jobcard.job_card_number),1),e("p",null,"Site: "+l(d.Jobcard.site),1)]),e("div",Z,[d.success?(o(),n("div",E,l(d.success),1)):u("",!0),e("div",G,[e("form",null,[e("div",K,[e("label",null,l(r.$page.props.ActivityTitle)+" Start Date:",1),f(x,{modelValue:s.start_date,"onUpdate:modelValue":t[0]||(t[0]=i=>s.start_date=i),position:"left",altPosition:""},null,8,["modelValue"])]),e("div",W,[s.SelectedOne?(o(),n("div",X,[I(e("input",{type:"number",class:"w-full py-1 border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm","onUpdate:modelValue":t[1]||(t[1]=i=>s.form.quantity=i),step:".01",placeholder:"Quantity measured"},null,512),[[q,s.form.quantity]]),s.form.type==="issue"?(o(),n("button",{key:0,onClick:t[2]||(t[2]=p(i=>a.issue(),["prevent"])),class:g([{"opacity-25":s.form.processing},"inline-flex justify-center rounded-md border border-transparent px-3 py-1 bg-blue-600 text-base leading-6 font-medium text-white shadow-sm hover:bg-blue-500 focus:outline-none focus:border-blue-700 focus:shadow-outline-blue transition ease-in-out duration-150 sm:text-sm sm:leading-5"]),disabled:s.form.processing}," Issue ",10,$)):(o(),n("button",{key:1,onClick:t[3]||(t[3]=p(i=>a.receive(),["prevent"])),class:g([{"opacity-25":s.form.processing},"inline-flex justify-center rounded-md border border-transparent px-3 py-1 bg-blue-600 text-base leading-6 font-medium text-white shadow-sm hover:bg-blue-500 focus:outline-none focus:border-blue-700 focus:shadow-outline-blue transition ease-in-out duration-150 sm:text-sm sm:leading-5"]),disabled:s.form.processing}," Receive ",10,ee))])):u("",!0),s.form.errors.quantity?(o(),n("p",te,l(s.form.errors.quantity),1)):u("",!0),e("table",se,[oe,e("tbody",null,[(o(!0),n(b,null,y(d.Jobcard.fruits,(i,_)=>(o(),n("tr",{key:_},[e("td",null,l(_+1),1),e("td",null,l(i.tree.tree_number),1),e("td",null,[(o(!0),n(b,null,y(i.stocks,(c,k)=>(o(),n("ol",{key:k},[e("li",ne,[e("p",null,"Issued: "+l(c.quantity),1),e("p",null,"Received: "+l(c.damage_seed),1),e("p",null,l(a.format_date(c.created_at)),1),e("p",null,[c.damage_seed===null?(o(),n("i",{key:0,onClick:p(ce=>a.selected(c.id,"receive"),["prevent"]),class:"fas fa-check text-blue-500 focus:text-blue-800 cursor-pointer"},null,8,re)):u("",!0)])])]))),128))]),e("td",null,[e("i",{onClick:c=>a.selected(i.id,"issue"),class:"fas fa-edit cursor-pointer text-green-500 hover:text-green-800"},null,8,ie)])]))),128))])])])]),e("div",le,[e("button",{onClick:t[4]||(t[4]=i=>a.complete(d.Jobcard.id)),class:"inline-flex justify-center rounded-md border border-transparent px-4 py-2 bg-green-600 text-base leading-6 font-medium text-white shadow-sm hover:bg-green-500 focus:outline-none focus:border-green-700 focus:shadow-outline-green transition ease-in-out duration-150 sm:text-sm sm:leading-5"}," Sign and Proceed ")])])])])])])])])])])])])]),_:1})],64)}const he=J(N,[["render",de]]);export{he as default};
