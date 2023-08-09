#include <iostream>

using namespace std;

int main(){
    int p = 5;
    int *ptr = &p;
    cout<<"NIlai dari A   : "<<p<<endl;
    cout<<"Address dari A : "<<ptr<<endl;
    
    cout<<"Alamat memori dari P : "<<&ptr<<endl;
    cout<<"Nilai dari p adalah : "<<*ptr<<endl;
    int *np = nullptr;
    cout<<"Null pointer   : "<<np<<endl;
    return 0;
}
