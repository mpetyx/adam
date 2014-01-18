function outp= visualise(data,n)
fill=[];
raw=[]
%[I11 J11]=max(target,[],2);
for a=1:40
placeholder=data(a,:)
raw(:,:,a)=reshape(placeholder(1:784),28,28);
end
imshow(raw(:,:,n));
outp = data(n,:)
%J11(n+1)
end