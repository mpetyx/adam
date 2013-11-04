import numpy
import math
import sys

final_matrix1=[]

with open("matlab.txt") as f:
	content = f.readlines()

for line in content:
	lin= line.replace(' \n','').split(' ')
	final_matrix1.append(map(numpy.float64,lin))

U, s, V = numpy.linalg.svd(final_matrix1, full_matrices=True)

# U.shape, V.shape, s.shape
# S = numpy.diag(s)






with open('outputfile','w') as fout:
	for line in V:
		fout.write(' '.join(map(str,line))+'\n')

with open('outputfile1','w') as fout:
	for line in U:
		fout.write(' '.join(map(str,line))+'\n')

strlen=len(s)
#s1 = [[0 for _ in range(strlen)] for _ in range(strlen)]
s1 = numpy.zeros((int(math.floor(math.sqrt(int(sys.argv[1])))), int(math.floor(math.sqrt(int(sys.argv[1]))))), dtype=complex)
s1[0:int(math.floor(math.sqrt(int(sys.argv[1])))), 0:int(math.floor(math.sqrt(int(sys.argv[1]))))] = numpy.diag(s[:int(math.floor(math.sqrt(int(sys.argv[1]))))])

for line in s1:
	line[:]=line[0 : int(math.floor(math.sqrt(int(sys.argv[1]))))]
s1=s1[0 : int(math.floor(math.sqrt(int(sys.argv[1]))))]

U1=[]
for line in U:
	U1.append(line[0 : int(math.floor(math.sqrt(int(sys.argv[1]))))])

# V=numpy.transpose(V)
Vt=V[0 : int(math.floor(math.sqrt(int(sys.argv[1]))))]
result = numpy.absolute(numpy.dot(numpy.dot(U1,s1),Vt))

with open('outputfile3','w') as fout:
	for line in result:
		fout.write(' '.join(map(str,line))+'\n')