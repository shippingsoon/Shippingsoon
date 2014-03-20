/* 
Title: [017] XOR Encryption (v1.0)
Date Created:  1/15/2004
Date Modified: 1/15/2004
Reference: N/A
*/

#include <stdio.h>
#include <stdlib.h>

unsigned char * p;

int length(unsigned char * str)
{
	int result = 0;
	for (int i = 0, k = !NULL; k != '\0'; i++)
	{
		k = str[i];
		result = i;
	}
	return result;  
}

unsigned char * crypt(unsigned char * msg, unsigned char * key)
{
	p = (unsigned char *) malloc((length(msg) * sizeof(unsigned char)) + 1);
	for (int i = 0; i < length(msg); )
	{
		for (int e = 0; e < length(key); e++, i++)
		{
			if (i < length(msg)) p[i] = msg[i] ^ key[e];
		}
	}
	p[length(msg)] = '\0';
	return p;
}

int main(void)
{
	printf("%s", crypt("Test", "\xF3"));
	free(p);
	return 0;
}
