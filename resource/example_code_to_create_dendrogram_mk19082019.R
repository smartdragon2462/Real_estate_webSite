
library(openxlsx)
library(graphics)

# set plot margins 
par(mar = par("mar") + c(0,0,0,3))

# load data into memory
data(USArrests)

# create clustering object
hc <- hclust(dist(USArrests), "ave")

# plot to be genrated in Excel
plot(as.dendrogram(hc),horiz=T, main = "Dendrogram to be constructed in Excel")

# inspect object
str(hc)

 
### code to write hc object to Excel

wb <- createWorkbook(creator    = "Maarten"
                     , title    = "Demo recreate R dendrogram"
                     , subject  = "coding R"
                     , category = "coding")


addWorksheet(wb , "hc", tabColour = "yellow")
writeData(wb, "hc", x = hc$merge, startCol = 1, startRow = 1)
writeData(wb, "hc", x = "merge_1", startCol = 1, startRow = 1)
writeData(wb, "hc", x = "merge_2", startCol = 2, startRow = 1)

addWorksheet(wb , "hc", tabColour = "yellow")
writeData(wb, "hc", x = hc$height, startCol = 3, startRow = 2)
writeData(wb, "hc", x = "height", startCol = 3, startRow = 1)

addWorksheet(wb , "hc", tabColour = "yellow")
writeData(wb, "hc", x = hc$order, startCol = 4, startRow = 2)
writeData(wb, "hc", x = "order", startCol = 4, startRow = 1)

addWorksheet(wb , "hc", tabColour = "yellow")
writeData(wb, "hc", x = hc$labels, startCol = 5, startRow = 2)
writeData(wb, "hc", x = "labels", startCol = 5, startRow = 1)

addWorksheet(wb , "hc", tabColour = "yellow")
writeData(wb, "hc", x = hc$method, startCol = 6, startRow = 2)
writeData(wb, "hc", x = "method", startCol = 6, startRow = 1)

addWorksheet(wb , "hc", tabColour = "yellow")
writeData(wb, "hc", x = hc$dist.method, startCol = 7, startRow = 2)
writeData(wb, "hc", x = "dist_method", startCol = 7, startRow = 1)

## Save workbook to working directory
saveWorkbook(wb, file = "c:/temp/hc_excel_created.xlsx", overwrite = TRUE) 


