import{B as k}from"./Authenticated-6f933b77.js";import{H as S,L as C,U as h,q as m,o as s,g as o,a as f,w as j,F as b,d as e,t as i,k as u,h as D,x as I,f as p,n as q,s as g}from"./app-7d6d683b.js";import{_ as B}from"./Record-edaaab17.js";import{Z as O}from"./main-18b6a265.js";import{s as V}from"./vue-multiselect.esm-22442a0d.js";import{_ as J}from"./_plugin-vue_export-helper-c27b6911.js";const A={components:{BreezeAuthenticatedLayout:k,Head:S,Link:C,Datepicker:O,Record:B,VueMultiselect:V},props:{Jobcard:Object,Users:Object,BeginDate:String,success:String},data(){return{form:this.$inertia.form({quantity:null,SelectedId:null,type:""}),SelectedOne:!1,start_date:this.$props.BeginDate}},methods:{issue(){this.form.patch(`/Depulping/store-quantity/${this.form.SelectedId}`,{onSuccess:()=>this.SelectedOne=!1,preserveScroll:!0})},receive(){this.form.post(`/seed-extraction/${this.form.SelectedId}/stock-issue-for-storage`,{onSuccess:()=>this.SelectedOne=!1,preserveScroll:!0})},complete(n){h.Inertia.get(route("complete.labelling",n))},destroy(n){confirm("Are you sure you want to remove")&&h.Inertia.delete(route("destroy.stockIssue",n))},selected(n,t){this.form.quantity=null,this.SelectedOne=!0,this.form.SelectedId=n,this.form.type=t},format_date(n){if(n)return moment(String(n)).format("DD-MM-YYYY")}}},L={class:"content-wrapper"},M=e("div",{class:"content-header"},[e("div",{class:"container-fluid"},[e("div",{class:"row mb-2"},[e("div",{class:"col-sm-6"},[e("h1",{class:"m-0"}," Job Card for Mukau Production ")]),e("div",{class:"col-sm-6"},[e("ol",{class:"breadcrumb float-sm-right"},[e("li",{class:"breadcrumb-item"},"Home"),e("li",{class:"breadcrumb-item active"},"job-card ")])])])])],-1),N={class:"content"},H={class:"container-fluid text-sm"},z={class:"row"},P={class:"col-lg-12 connectedSortable"},R={class:"py-6"},U={class:"max-w-7xl mx-auto sm:px-6 lg:px-8"},Y={class:"bg-white overflow-hidden shadow-sm sm:rounded-lg"},T={class:"p-4 bg-white border-b border-gray-200"},F={class:"card-header flex justify-between"},Q=e("h3",{class:"card-title"},"Job Card Review",-1),Z={class:"card-body"},E={key:0,class:"p-2 mb-1 text-sm text-blue-700 bg-blue-100 rounded-lg",role:"alert"},G={class:"col-sm-12 pt-8"},K={class:"form-group"},W={class:"flex flex-col rounded-md shadow-lg px-3 py-2 pt-3"},X={key:0,class:"flex items-center justify-between space-x-2"},$=["disabled"],ee={key:1,class:"text-xs text-red-600 mt-2"},te={class:"table table-hover text-nowrap mt-6"},se=e("thead",null,[e("tr",null,[e("th",null,"No"),e("th",null,"Tree Number"),e("th",null,"Quantity Issued(no)"),e("th",null,"Action")])],-1),oe={class:"flex justify-between items-center space-x-3 mt-2"},ne=["onClick"],re=["onClick"],le={class:"flex justify-end mt-4"};function ie(n,t,d,de,r,a){const y=m("Head"),v=m("Datepicker"),x=m("BreezeAuthenticatedLayout");return s(),o(b,null,[f(y,{title:"Operational Planning"}),f(x,null,{default:j(()=>[e("div",L,[M,e("section",N,[e("div",H,[e("div",z,[e("section",P,[e("div",R,[e("div",U,[e("div",Y,[e("div",T,[e("div",F,[Q,e("p",null,"Card No: "+i(d.Jobcard.job_card_number),1),e("p",null,"Site: "+i(d.Jobcard.site),1)]),e("div",Z,[d.success?(s(),o("div",E,i(d.success),1)):u("",!0),e("div",G,[e("form",null,[e("div",K,[e("label",null,i(n.$page.props.ActivityTitle)+" Start Date:",1),f(v,{modelValue:r.start_date,"onUpdate:modelValue":t[0]||(t[0]=l=>r.start_date=l),position:"left",altPosition:""},null,8,["modelValue"])]),e("div",W,[r.SelectedOne?(s(),o("div",X,[D(e("input",{type:"number",class:"w-full py-1 border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm","onUpdate:modelValue":t[1]||(t[1]=l=>r.form.quantity=l),step:".01",placeholder:"Quantity measured"},null,512),[[I,r.form.quantity]]),r.form.type==="issue"?(s(),o("button",{key:0,onClick:t[2]||(t[2]=p(l=>a.issue(),["prevent"])),class:q([{"opacity-25":r.form.processing},"inline-flex justify-center rounded-md border border-transparent px-3 py-1 bg-blue-600 text-base leading-6 font-medium text-white shadow-sm hover:bg-blue-500 focus:outline-none focus:border-blue-700 focus:shadow-outline-blue transition ease-in-out duration-150 sm:text-sm sm:leading-5"]),disabled:r.form.processing}," Issue ",10,$)):(s(),o("button",{key:1,onClick:t[3]||(t[3]=p(l=>a.receive(),["prevent"])),class:"inline-flex justify-center rounded-md border border-transparent px-3 py-1 bg-blue-600 text-base leading-6 font-medium text-white shadow-sm hover:bg-blue-500 focus:outline-none focus:border-blue-700 focus:shadow-outline-blue transition ease-in-out duration-150 sm:text-sm sm:leading-5"}," Receive "))])):u("",!0),r.form.errors.quantity?(s(),o("p",ee,i(r.form.errors.quantity),1)):u("",!0),e("table",te,[se,e("tbody",null,[(s(!0),o(b,null,g(d.Jobcard.fruits,(l,_)=>(s(),o("tr",{key:_},[e("td",null,i(_+1),1),e("td",null,i(l.tree.tree_number),1),e("td",null,[(s(!0),o(b,null,g(l.stocks,(c,w)=>(s(),o("ol",{key:w},[e("li",oe,[e("p",null,"Issued: "+i(c.quantity),1),e("p",null,"Received: "+i(c.damage_seed),1),e("p",null,i(a.format_date(c.created_at)),1),e("p",null,[c.damage_seed===null?(s(),o("i",{key:0,onClick:p(ae=>a.selected(c.id,"receive"),["prevent"]),class:"fas fa-check text-blue-500 focus:text-blue-800 cursor-pointer"},null,8,ne)):u("",!0)])])]))),128))]),e("td",null,[e("i",{onClick:c=>a.selected(l.id,"issue"),class:"fas fa-edit cursor-pointer text-green-500 hover:text-green-800"},null,8,re)])]))),128))])])])]),e("div",le,[e("button",{onClick:t[4]||(t[4]=l=>a.complete(d.Jobcard.id)),class:"inline-flex justify-center rounded-md border border-transparent px-4 py-2 bg-green-600 text-base leading-6 font-medium text-white shadow-sm hover:bg-green-500 focus:outline-none focus:border-green-700 focus:shadow-outline-green transition ease-in-out duration-150 sm:text-sm sm:leading-5"}," Sign and Proceed ")])])])])])])])])])])])])]),_:1})],64)}const _e=J(A,[["render",ie]]);export{_e as default};
