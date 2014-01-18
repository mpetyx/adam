function outp= classify(data1,w1,w2,w3,N1,w_class)
  clear targetout
  clear J
  clear I
  w1probs = 1./(1 + exp(-data1*w1)); w1probs = [w1probs  ones(N1,1)];
  w2probs = 1./(1 + exp(-w1probs*w2)); w2probs = [w2probs ones(N1,1)];
  w3probs = 1./(1 + exp(-w2probs*w3)); w3probs = [w3probs  ones(N1,1)];
  targetout = exp(w3probs*w_class);
  targetout = targetout./repmat(sum(targetout,2),1,10);  
  [I J]=max(targetout,[],2);
  outp=J-1
end