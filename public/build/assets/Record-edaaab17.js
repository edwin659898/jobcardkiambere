import{o as i,g as n,d as e,t as c,F as a,s as l,k as o}from"./app-7d6d683b.js";const d={class:"font-bold text-red-500"},r={class:"flex justify-between pt-2"},_={class:"flex justify-center"},u={class:"block bg-white text-center"},b={class:"py-3 px-6 border-b border-gray-300"},h={class:"p-6"},m=e("p",{class:"text-gray-700 text-xs mb-4"}," Documents attached and locations ",-1),x={key:0,class:"flex justify-between items-center space-x-2"},y=["innerHTML"],f=["innerHTML"],v={class:"flex justify-center"},g={class:"block bg-white text-center"},k={class:"py-3 px-6 border-b border-gray-300"},L={class:"p-6"},j=e("p",{class:"text-gray-700 text-xs mb-4"}," Persons who signed ",-1),p={key:0,class:"flex justify-between items-center space-x-2"},w=["innerHTML"],H=["innerHTML"],N={__name:"Record",props:{Data:Object,Activity:String,childNumber:Number},setup(t){return(M,T)=>(i(),n(a,null,[e("p",d,c(t.Activity)+" "+c(t.Data.timelines[0].start_date)+" - "+c(t.Data.timelines[0].end_date),1),e("div",r,[e("div",_,[e("div",u,[e("div",b,c(t.Activity),1),e("div",h,[m,(i(!0),n(a,null,l(t.Data.confirmedrecords,s=>(i(),n("div",{key:s.id,class:"flex justify-between items-center space-x-2"},[s.activity_child.child_number==t.childNumber?(i(),n("div",x,[e("label",{class:"mt-2 text-sm font-bold",innerHTML:s.record},null,8,y),e("p",{class:"text-gray-400",innerHTML:s.pivot.location},null,8,f)])):o("",!0)]))),128))])])]),e("div",v,[e("div",g,[e("div",k,c(t.Activity)+" Signatures ",1),e("div",L,[j,(i(!0),n(a,null,l(t.Data.signatures,s=>(i(),n("div",{key:s.id,class:"flex justify-between items-center space-x-2"},[s.son_activity.child_number==t.childNumber?(i(),n("div",p,[e("label",{class:"mt-2 text-sm font-bold",innerHTML:s.role.role},null,8,w),e("p",{class:"text-gray-400",innerHTML:s.user.name},null,8,H)])):o("",!0)]))),128))])])])])],64))}};export{N as _};
