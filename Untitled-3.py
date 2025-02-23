class frt:
    def __init__(self,name):
        self.name=name
    def setFruitName(self,name):
        self.name=name
    def getFruitName(self):
        return self.name
    
f=frt("apple")
print(f.getFruitName())
f.setFruitName("banana")
print(f.getFruitName())
