from wasmer import engine, Store, Module, Instance
from wasmer_compiler_llvm import Compiler
import os
import sys
import time 

t0 = time.perf_counter_ns()
engine = engine.JIT(Compiler)

# Create a store, that holds the engine.
store = Store(engine)

# Let's compile the Wasm module with the LLVM compiler.
__dir__ = os.path.dirname(os.path.realpath(__file__))
module = Module(store, open(__dir__ + '/../wasm_binaries/rust_wasm_square_free.wasm', 'rb').read())

# Let's instantiate the Wasm module.
instance = Instance(module)
t1 = time.perf_counter_ns()
compilation_time = t1 - t0 
print("\r\n instantiating the wasm module took: %f nanoseconds \r\n" %(compilation_time))

def is_square_free_wasm(base, exponent, sub):
    global instance
    return (instance.exports.is_square_free(base,exponent,sub) == 1)

base = int(sys.argv[1])
exponent = int(sys.argv[2])
sub = int(sys.argv[3])
print("%d^%d - %d is ... \r\n" %(base,exponent,sub))
t0 = time.perf_counter()
result = is_square_free_wasm(base,exponent,sub)
t1 = time.perf_counter()
call_time = t1 - t0 
if result:
    print("square free \r\n")
else:
    print("not square free \r\n")
print("Function call took %f seconds \r\n" %(call_time))