l=[]
p=[]
x=1
max=0
while(x!=0):
 id=""

 print("optopn1")
 print("optopn 2")
 print("optopn 3")

 print("option 4")
 d=int(input("choice:--->"))
 if(d==1):
  n=int(input("enter the number of eleemts"))
  for i in range(0,n):
     n1=int(input("enter the  eleemts"))
     l.append(n1)
 if(d==2):
  print(l)
 if(d==3):
   exit()
 if(d==4):
   del l[-1]

    