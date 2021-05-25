from wasmer import Store, Module, Instance
import os
import sys
import time 

# Instantiate the Webassembly module.
__dir__ = os.path.dirname(os.path.realpath(__file__))
module = Module(Store(), open(__dir__ + '/../wasm_binaries/rust_fib.wasm', 'rb').read())
instance = Instance(module)

def fib_wasm(n):
    global instance
    return instance.exports.fib(n)

n = int(sys.argv[1])
t0 = time.perf_counter()
result = fib_wasm(n)
t1 = time.perf_counter()
call_time = t1 - t0 
print("The %d'th Fibonacci number is : %d \r\n" %(n,result))
print("Function call took %f seconds \r\n" %(call_time))

