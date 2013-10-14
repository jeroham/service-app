SELECT 
t.ticketid,
c.company_name,
c.contact_first_name,
c.contact_last_name,
t.description

FROM `ticket` t
INNER JOIN 
`employee` e
on e.employeeid=t.employeeid
inner join `customer` c
on c.customerid=t.customerid
WHERE t.status = 'Open'
AND t.employeeid = ?
order by 1 asc
