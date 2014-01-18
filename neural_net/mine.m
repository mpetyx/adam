function outp= mine(x)
outp=reshape(x,28,28)
end
fill=[];
raw=[]
for a=1:40
placeholder=data(a,:)
%raw(:,:)=reshape(placeholder(1:784),28,28);
placeholder1(:,:)=reshape(placeholder(1:784),28,28)
for a1=1:28 
raw=[placeholder1(a1,:);raw];
end
end


dlmwrite('predicted_labels.txt',J(1:40)-1,'\n')
dlmwrite('w1.txt', w1);
dlmwrite('w2.txt', w2);
dlmwrite('w3.txt', w3);
dlmwrite('w_class.txt', w_class);

w_class = 0.1*randn(size(w3,2)+1,10);
test_err=[];
train_err=[];
epoch=1
err=0;
err_cr=0;
counter=0;
[testnumcases testnumdims testnumbatches]=size(testbatchdata);
N=testnumcases;
%for batch = 1:testnumbatches
  data = [testbatchdata(:,:,2)];
  target = [testbatchtargets(:,:,2)];
  data = [data ones(N,1)];
  w1probs = 1./(1 + exp(-data*w1)); w1probs = [w1probs  ones(N,1)];
  w2probs = 1./(1 + exp(-w1probs*w2)); w2probs = [w2probs ones(N,1)];
  w3probs = 1./(1 + exp(-w2probs*w3)); w3probs = [w3probs  ones(N,1)];
  targetout = exp(w3probs*w_class);
  targetout = targetout./repmat(sum(targetout,2),1,10);
%scatter(targetout(:,1),targetout(:,2))
  [I J]=max(targetout,[],2);
  [I1 J1]=max(target,[],2);
  
   
  counter=counter+length(find(J==J1));
  err_cr = err_cr- sum(sum( target(:,1:end).*log(targetout))) ;
%end
 test_err(epoch)=(testnumcases*testnumbatches-counter);
 test_crerr(epoch)=err_cr/testnumbatches;
 fprintf(1,'Before epoch %d Train # misclassified: %d (from %d). Test # misclassified: %d (from %d) \t \t \n',...
            epoch,train_err(epoch),numcases*numbatches,test_err(epoch),testnumcases*testnumbatches); 
  
  
 