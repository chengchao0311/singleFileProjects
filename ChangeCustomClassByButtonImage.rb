require 'rexml/document'
include REXML
files = Dir.glob("**/*.xib")
for file_path in files
   fileContent = File.new(file_path)
   xmldoc = Document.new(fileContent)
   target = XPath.match(xmldoc, "//*[@backgroundImage='btn_blank_03.png']")
   for row in target
      row.parent.add_attribute('customClass','PageThemeButton3')
   end

   File.open(file_path, "w") do |data|
      data<<xmldoc
   end
end



