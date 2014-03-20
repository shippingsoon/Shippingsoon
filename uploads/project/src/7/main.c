/* 
Title: [021] Linked List (v1.1)
Date Created:  1/20/2004
Date Modified: 1/20/2004
Reference: http://richardbowles.tripod.com/cpp/linklist/linklist.htm
*/

#include <stdio.h>
#include <stdlib.h>
#include <stdbool.h>

struct Store
{
	char * name;
	float price, total;
	int quantity;
	struct Store * next;
};

struct Store * start = NULL;

bool buy(char * n, float p, int q)
{
	struct Store * temp, * temp2;
	if (!(temp = (struct Store *) malloc(sizeof(struct Store))))
		return false;
	temp->name = n;
	temp->price = p;
	temp->quantity = q;
	temp->total = (p * q);
	temp->next = NULL;
	if (start == NULL)
	{
		start = temp;
	}
	else
	{
		temp2 = start;
		while (temp2->next != NULL)
		{
			temp2 = temp2->next;
		}	
		temp2->next = temp;
	}
}

bool strcompare(const char * str, const char * s)
{
	if (strlength(str) != strlength(s))
		return false;
	int i;
	for (i = 0; i < strlength(str); i++)
	{
		if (str[i] < 91)
		{
			if (str[i] != s[i] && s[i] != str[i]+32)
				return false;
		}
		else 
		{
			if (str[i] != s[i] && s[i] != str[i]-32)
				return false;
		}
	}
	return true;
}

bool print_order(const char * s)
{
	struct Store * tmp;
	tmp = start;
	while (tmp)
	{
		if (strcompare(tmp->name, s))
		{
			printf("Name:\t\t%s\n", (tmp->name) ? tmp->name : "N\\A");
			printf("Price:\t\t$%.2f\n", (tmp->price) ? tmp->price : 0);
			printf("Quantity:\t%i\n", (tmp->quantity) ? tmp->quantity : 0);
			printf("Total:\t\t$%.2f\n", (tmp->total) ? tmp->total : 0);
			printf("--------------------\n");
			return true;
		}
		tmp = tmp->next;
	}
	printf("%s could not be found.\n", s);
	return false;
}

bool print_orders()
{
	struct Store * temp;
	temp = start;
	do 
	{
		if (temp == NULL)
		{
			printf("List is empty\n");
			return false;
		}
		else 
		{
			printf("Name:\t\t%s\n", (temp->name) ? temp->name : "N\\A");
			printf("Price:\t\t$%.2f\n", (temp->price) ? temp->price : 0);
			printf("Quantity:\t%i\n", (temp->quantity) ? temp->quantity : 0);
			printf("Total:\t\t$%.2f\n", (temp->total) ? temp->total : 0);
			printf("--------------------\n");
			temp = temp->next;
		}
	}
	while (temp != NULL);
	return true;
}

bool search(char * s)
{
	struct Store * tmp;
	tmp = start;
	while (tmp)
	{
		if (strcompare(s, tmp->name))
		{
			printf("Found %s...\n", s);
			return true;
		}
		else tmp = tmp->next;
	}
	printf("%s were not found...\n", s);
	return false;
}

void remove_first_order()
{
	struct Store * temp;
	temp = start;
	start = start->next;
	printf("Deleting %s....\n", temp->name);
	if (temp != NULL) 
	{
		free(temp);
	}
}

void finish()
{
	struct Store * temp;
	do
	{
		temp = start;
		if (temp != NULL) start = start->next;
		if (temp != NULL) printf("Deleting %s....\n", temp->name);
		if (temp != NULL) 
		{
			free(temp);
		}
	}
	while(temp != NULL);
}

int strlength(const char * s)
{
	int i, count;
	for (i = 0; *(s+i); i++)
	{
		count = i;
	}
	return i;
}

int main(void)
{
	buy("Apples", 2.50, 2);
	buy("Oranges", 1.00, 8);
	buy("Grapes", .10, 10);
	print_order("apples");
	finish();
	printf("\n--------------------\n");
	return 0;
}
