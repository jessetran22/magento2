<?php
namespace Magento\AcceptanceTest\_default\Backend;

use Magento\FunctionalTestingFramework\AcceptanceTester;
use \Codeception\Util\Locator;
use Yandex\Allure\Adapter\Annotation\Features;
use Yandex\Allure\Adapter\Annotation\Stories;
use Yandex\Allure\Adapter\Annotation\Title;
use Yandex\Allure\Adapter\Annotation\Description;
use Yandex\Allure\Adapter\Annotation\Parameter;
use Yandex\Allure\Adapter\Annotation\Severity;
use Yandex\Allure\Adapter\Model\SeverityLevel;
use Yandex\Allure\Adapter\Annotation\TestCaseId;

/**
 * @Title("MC-6338: Admin create text editor product attribute test")
 * @Description("Create text editor product attribute with TinyMCE enabled<h3>Test files</h3>app/code/Magento/Catalog/Test/Mftf/Test/AdminCreateTextEditorProductAttributeTest.xml<br>")
 * @TestCaseId("MC-6338")
 * @group catalog
 */
class AdminCreateTextEditorProductAttributeTestCest
{
    /**
     * @var \Magento\FunctionalTestingFramework\Helper\HelperContainer
     */
    private $helperContainer;

    /**
     * Special method which automatically creates the respective objects.
     */
    public function _inject(\Magento\FunctionalTestingFramework\Helper\HelperContainer $helperContainer)
    {
        $this->helperContainer = $helperContainer;
        $this->helperContainer->create("Magento\Catalog\Test\Mftf\Helper\LocalFileAssertions");
    }
	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _before(AcceptanceTester $I)
	{
		$I->comment("Enable WYSIWYG editor");
		$I->comment("Entering Action Group [enableWYSIWYG] EnabledWYSIWYGActionGroup");
		$enableWYSIWYGEnableWYSIWYG = $I->magentoCLI("config:set cms/wysiwyg/enabled enabled", 60); // stepKey: enableWYSIWYGEnableWYSIWYG
		$I->comment($enableWYSIWYGEnableWYSIWYG);
		$I->comment("Exiting Action Group [enableWYSIWYG] EnabledWYSIWYGActionGroup");
		$I->comment("Enable TinyMCE 4");
		$I->comment("Entering Action Group [enableTinyMCE] CliEnableTinyMCEActionGroup");
		$enableTinyMCEEnableTinyMCE = $I->magentoCLI("config:set cms/wysiwyg/editor mage/adminhtml/wysiwyg/tiny_mce/tinymce5Adapter", 60); // stepKey: enableTinyMCEEnableTinyMCE
		$I->comment($enableTinyMCEEnableTinyMCE);
		$I->comment("Exiting Action Group [enableTinyMCE] CliEnableTinyMCEActionGroup");
		$I->comment("Login as admin");
		$I->comment("Entering Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin
		$I->comment("Exiting Action Group [loginAsAdmin] AdminLoginActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Delete attribute");
		$I->comment("Entering Action Group [deleteAttribute] DeleteProductAttributeActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product_attribute"); // stepKey: navigateToProductAttributeGridDeleteAttribute
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clearExistingFiltersDeleteAttribute
		$I->waitForPageLoad(30); // stepKey: clearExistingFiltersDeleteAttributeWaitForPageLoad
		$I->fillField("#attributeGrid_filter_attribute_code", "attribute" . msq("productTextEditorAttribute")); // stepKey: setAttributeCodeDeleteAttribute
		$I->click("button[data-action=grid-filter-apply]"); // stepKey: searchForAttributeFromTheGridDeleteAttribute
		$I->waitForPageLoad(30); // stepKey: searchForAttributeFromTheGridDeleteAttributeWaitForPageLoad
		$I->click("//*[@id='attributeGrid_table']/tbody/tr[1]"); // stepKey: clickOnAttributeRowDeleteAttribute
		$I->waitForPageLoad(30); // stepKey: clickOnAttributeRowDeleteAttributeWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad2DeleteAttribute
		$I->click("#delete"); // stepKey: deleteAttributeDeleteAttribute
		$I->waitForPageLoad(30); // stepKey: deleteAttributeDeleteAttributeWaitForPageLoad
		$I->click("//footer[@class='modal-footer']/button[contains(@class, 'action-accept')]"); // stepKey: ClickOnDeleteButtonDeleteAttribute
		$I->waitForPageLoad(30); // stepKey: ClickOnDeleteButtonDeleteAttributeWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadDeleteAttribute
		$I->seeElement(".message.message-success.success"); // stepKey: waitForSuccessMessageDeleteAttribute
		$I->comment("Exiting Action Group [deleteAttribute] DeleteProductAttributeActionGroup");
		$I->comment("Delete product");
		$I->comment("Entering Action Group [deleteProduct] DeleteProductUsingProductGridActionGroup");
		$I->comment("TODO use other action group for filtering grid when MQE-539 is implemented");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: visitAdminProductPageDeleteProduct
		$I->waitForPageLoad(60); // stepKey: waitForPageLoadInitialDeleteProduct
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersInitialDeleteProduct
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersInitialDeleteProductWaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFiltersDeleteProduct
		$I->fillField("input.admin__control-text[name='sku']", "testSku" . msq("_defaultProduct")); // stepKey: fillProductSkuFilterDeleteProduct
		$I->fillField("input.admin__control-text[name='name']", "testProductName" . msq("_defaultProduct")); // stepKey: fillProductNameFilterDeleteProduct
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersDeleteProduct
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersDeleteProductWaitForPageLoad
		$I->see("testSku" . msq("_defaultProduct"), "//tr[1]//td[count(//div[@data-role='grid-wrapper']//tr//th[normalize-space(.)='SKU']/preceding-sibling::th) +1 ]"); // stepKey: seeProductSkuInGridDeleteProduct
		$I->click("div[data-role='grid-wrapper'] th.data-grid-multicheck-cell button.action-multicheck-toggle"); // stepKey: openMulticheckDropdownDeleteProduct
		$I->click("//div[@data-role='grid-wrapper']//th[contains(@class, data-grid-multicheck-cell)]//li//span[text() = 'Select All']"); // stepKey: selectAllProductInFilteredGridDeleteProduct
		$I->click("div.admin__data-grid-header-row.row div.action-select-wrap button.action-select"); // stepKey: clickActionDropdownDeleteProduct
		$I->waitForPageLoad(30); // stepKey: clickActionDropdownDeleteProductWaitForPageLoad
		$I->click("//div[contains(@class,'admin__data-grid-header-row') and contains(@class, 'row')]//div[contains(@class, 'action-select-wrap')]//ul/li/span[text() = 'Delete']"); // stepKey: clickDeleteActionDeleteProduct
		$I->waitForPageLoad(30); // stepKey: clickDeleteActionDeleteProductWaitForPageLoad
		$I->waitForElementVisible(".modal-popup.confirm h1.modal-title", 30); // stepKey: waitForConfirmModalDeleteProduct
		$I->click(".modal-popup.confirm button.action-accept"); // stepKey: confirmProductDeleteDeleteProduct
		$I->waitForPageLoad(60); // stepKey: confirmProductDeleteDeleteProductWaitForPageLoad
		$I->comment("Exiting Action Group [deleteProduct] DeleteProductUsingProductGridActionGroup");
		$I->comment("Log out");
		$I->comment("Entering Action Group [logout] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogout
		$I->comment("Exiting Action Group [logout] AdminLogoutActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _failed(AcceptanceTester $I)
	{
		$I->saveScreenshot(); // stepKey: saveScreenshot
	}

	/**
	 * @Features({"Catalog"})
	 * @Stories({"Create product Attribute"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminCreateTextEditorProductAttributeTest(AcceptanceTester $I)
	{
		$I->comment("Go to Stores > Product, click \"Add New Attribute\"");
		$I->comment("Entering Action Group [openProductAttributePage] AdminOpenProductAttributePageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product_attribute"); // stepKey: goToAttributePageOpenProductAttributePage
		$I->waitForPageLoad(30); // stepKey: waitForAttributePageLoadOpenProductAttributePage
		$I->comment("Exiting Action Group [openProductAttributePage] AdminOpenProductAttributePageActionGroup");
		$I->click("#add"); // stepKey: createNewAttribute
		$I->comment("Input value for Default Label. Verify dropdown of \"Catalog Input Type for Store Owner\"");
		$I->comment("Entering Action Group [fillAttributeProperties] AdminFillProductAttributePropertiesActionGroup");
		$I->fillField("#attribute_label", "attribute" . msq("productTextEditorAttribute")); // stepKey: fillDefaultLabelFillAttributeProperties
		$I->selectOption("#frontend_input", "texteditor"); // stepKey: selectInputTypeFillAttributeProperties
		$I->comment("Exiting Action Group [fillAttributeProperties] AdminFillProductAttributePropertiesActionGroup");
		$I->comment("Input value for \"Catalog Input Type for Store Owner\"");
		$I->selectOption("#frontend_input", "textarea"); // stepKey: updateInputType
		$I->comment("Click on \"Storefront Properties\" tab on left menu");
		$I->click("#product_attribute_tabs_front"); // stepKey: clickStorefrontPropertiesTab
		$I->dontSeeElement("#enabled"); // stepKey: dontSeeWYSIWYGEnableField
		$I->comment("Selection for \"Visible on Catalog Pages on Storefront\"");
		$I->selectOption("#is_visible_on_front", "Yes"); // stepKey: enableVisibleOnStorefront
		$I->scrollToTopOfPage(); // stepKey: scrollToPageTop
		$I->comment("Go back to \"Properties\" tab on left menu");
		$I->click("#product_attribute_tabs_main"); // stepKey: clickPropertiesTab
		$I->comment("Updated value for \"Catalog Input Type for Store Owner\"");
		$I->selectOption("#frontend_input", "texteditor"); // stepKey: returnInputType
		$I->comment("Save Product Attribute");
		$I->comment("Entering Action Group [saveAttribute] SaveProductAttributeActionGroup");
		$I->waitForElementVisible("#save", 30); // stepKey: waitForSaveButtonSaveAttribute
		$I->waitForPageLoad(30); // stepKey: waitForSaveButtonSaveAttributeWaitForPageLoad
		$I->click("#save"); // stepKey: clickSaveButtonSaveAttribute
		$I->waitForPageLoad(30); // stepKey: clickSaveButtonSaveAttributeWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForAttributeToSaveSaveAttribute
		$I->seeElement(".message.message-success.success"); // stepKey: seeSuccessMessageSaveAttribute
		$I->comment("Exiting Action Group [saveAttribute] SaveProductAttributeActionGroup");
		$I->comment("Go to Store > Attribute Set");
		$I->comment("Entering Action Group [openAttributeSetPage] AdminOpenAttributeSetGridPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product_set/"); // stepKey: goToAttributeSetPageOpenAttributeSetPage
		$I->waitForPageLoad(30); // stepKey: waitForAttributeSetPageLoadOpenAttributeSetPage
		$I->comment("Exiting Action Group [openAttributeSetPage] AdminOpenAttributeSetGridPageActionGroup");
		$I->comment("From grid, click on attribute set Default");
		$I->comment("Entering Action Group [openDefaultAttributeSet] AdminOpenAttributeSetByNameActionGroup");
		$I->click("//td[contains(text(), 'Default')]"); // stepKey: chooseAttributeSetOpenDefaultAttributeSet
		$I->waitForPageLoad(30); // stepKey: waitForAttributeSetPageLoadOpenDefaultAttributeSet
		$I->comment("Exiting Action Group [openDefaultAttributeSet] AdminOpenAttributeSetByNameActionGroup");
		$I->comment("Add Product Attribute to Default attribute by dragging and dropping this to the 'Project Details' folder. Then Save.");
		$I->comment("Entering Action Group [assignAttributeToGroup] AssignAttributeToGroupActionGroup");
		$I->conditionalClick("//*[@id='tree-div1']//span[text()='Product Details']", "//*[@id='tree-div1']//span[text()='Product Details']/parent::*/parent::*[contains(@class, 'collapsed')]", true); // stepKey: extendGroupAssignAttributeToGroup
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad1AssignAttributeToGroup
		$I->dragAndDrop("//*[@id='tree-div2']//span[text()='attribute" . msq("productTextEditorAttribute") . "']", "//*[@id='tree-div1']//span[text()='Product Details']/parent::*/parent::*/parent::*//li[1]//a/span"); // stepKey: dragAndDropToGroupProductDetailsAssignAttributeToGroup
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad2AssignAttributeToGroup
		$I->see("attribute" . msq("productTextEditorAttribute"), "#tree-div1"); // stepKey: seeAttributeInGroupAssignAttributeToGroup
		$I->comment("Exiting Action Group [assignAttributeToGroup] AssignAttributeToGroupActionGroup");
		$I->comment("Entering Action Group [saveAttributeSet] SaveAttributeSetActionGroup");
		$I->click("button[title='Save']"); // stepKey: clickSaveSaveAttributeSet
		$I->waitForPageLoad(30); // stepKey: clickSaveSaveAttributeSetWaitForPageLoad
		$I->see("You saved the attribute set", "#messages div.message-success"); // stepKey: successMessageSaveAttributeSet
		$I->comment("Exiting Action Group [saveAttributeSet] SaveAttributeSetActionGroup");
		$I->comment("Go Catalog > Product to create new product page");
		$I->comment("Entering Action Group [goToProductIndexPage] AdminOpenProductIndexPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: goToProductIndexPageGoToProductIndexPage
		$I->waitForPageLoad(30); // stepKey: waitForProductIndexPageLoadGoToProductIndexPage
		$I->comment("Exiting Action Group [goToProductIndexPage] AdminOpenProductIndexPageActionGroup");
		$I->comment("Entering Action Group [goToCreateProduct] GoToCreateProductPageActionGroup");
		$I->click(".action-toggle.primary.add"); // stepKey: clickAddProductToggleGoToCreateProduct
		$I->waitForPageLoad(30); // stepKey: clickAddProductToggleGoToCreateProductWaitForPageLoad
		$I->waitForElementVisible(".item[data-ui-id='products-list-add-new-product-button-item-simple']", 30); // stepKey: waitForAddProductDropdownGoToCreateProduct
		$I->click(".item[data-ui-id='products-list-add-new-product-button-item-simple']"); // stepKey: clickAddProductTypeGoToCreateProduct
		$I->waitForPageLoad(30); // stepKey: waitForCreateProductPageLoadGoToCreateProduct
		$I->seeInCurrentUrl((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/new/set/4/type/simple/"); // stepKey: seeNewProductUrlGoToCreateProduct
		$I->see("New Product", ".page-header h1.page-title"); // stepKey: seeNewProductTitleGoToCreateProduct
		$I->comment("Exiting Action Group [goToCreateProduct] GoToCreateProductPageActionGroup");
		$I->comment("On product page, select Attribute Set: \"Default\"");
		$I->comment("Entering Action Group [selectAttributeSet] AdminProductPageSelectAttributeSetActionGroup");
		$I->click("div[data-index='attribute_set_id'] .admin__field-control"); // stepKey: openDropdownSelectAttributeSet
		$I->fillField("div[data-index='attribute_set_id'] .admin__field-control input", "Default"); // stepKey: filterSelectAttributeSet
		$I->waitForPageLoad(30); // stepKey: filterSelectAttributeSetWaitForPageLoad
		$I->click("div[data-index='attribute_set_id'] .action-menu-item._last"); // stepKey: clickResultSelectAttributeSet
		$I->waitForPageLoad(30); // stepKey: clickResultSelectAttributeSetWaitForPageLoad
		$I->comment("Exiting Action Group [selectAttributeSet] AdminProductPageSelectAttributeSetActionGroup");
		$I->comment("Created product attribute appear on product form");
		$I->seeElement("//*[@class='admin__field']//span[text()='attribute" . msq("productTextEditorAttribute") . "']"); // stepKey: seeAttributeLabelInProductForm
		$I->comment("TinyMCE 4 is displayed in WYSIWYG content area");
		$I->seeElement(".tox-tinymce"); // stepKey: seeTinyMCE
		$I->comment("Verify toolbar menu");
		$I->comment("Entering Action Group [verifyToolbarMenu] VerifyTinyMCEActionGroup");
		$I->seeElement("button[title='Blocks']"); // stepKey: assertInfo2VerifyToolbarMenu
		$I->seeElement("button[title='Bold']"); // stepKey: assertInfo3VerifyToolbarMenu
		$I->seeElement("button[title='Italic']"); // stepKey: assertInfo4VerifyToolbarMenu
		$I->seeElement("button[title='Underline']"); // stepKey: assertInfo5VerifyToolbarMenu
		$I->seeElement("button[title='Align left']"); // stepKey: assertInfo6VerifyToolbarMenu
		$I->seeElement("button[title='Align center']"); // stepKey: assertInfo7VerifyToolbarMenu
		$I->seeElement("button[title='Align right']"); // stepKey: assertInfo8VerifyToolbarMenu
		$I->seeElement("div[title='Numbered list']"); // stepKey: assertInfo9VerifyToolbarMenu
		$I->seeElement("div[title='Bullet list']"); // stepKey: assertInfo10VerifyToolbarMenu
		$I->seeElement("button[title='Insert/edit link']"); // stepKey: assertInfo11VerifyToolbarMenu
		$I->seeElement("button[title='Insert/edit image']"); // stepKey: assertInf12VerifyToolbarMenu
		$I->waitForPageLoad(30); // stepKey: assertInf12VerifyToolbarMenuWaitForPageLoad
		$I->seeElement("button[title='Table']"); // stepKey: assertInfo13VerifyToolbarMenu
		$I->seeElement("button[title='Special character']"); // stepKey: assertInfo14VerifyToolbarMenu
		$I->comment("Exiting Action Group [verifyToolbarMenu] VerifyTinyMCEActionGroup");
		$I->comment("Click Show/Hide button and see Insert Image button");
		$I->scrollToTopOfPage(); // stepKey: scrollToTop
		$I->click("div[data-index='attribute" . msq("productTextEditorAttribute") . "'] .scalable.action-show-hide"); // stepKey: clickShowHideBtn
		$I->waitForElementVisible(".scalable.action-add-image.plugin", 30); // stepKey: waitForInsertImageBtn
		$I->comment("Add content into attribute");
		$I->fillField("#product_form_attribute" . msq("productTextEditorAttribute"), "This content from product page"); // stepKey: setContent
		$I->waitForPageLoad(30); // stepKey: setContentWaitForPageLoad
		$I->comment("Fill up all required fields for product form");
		$I->comment("Entering Action Group [fillProductForm] FillMainProductFormActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollToTopOfPageFillProductForm
		$I->fillField(".admin__field[data-index=name] input", "testProductName" . msq("_defaultProduct")); // stepKey: fillProductNameFillProductForm
		$I->fillField(".admin__field[data-index=sku] input", "testSku" . msq("_defaultProduct")); // stepKey: fillProductSkuFillProductForm
		$I->fillField(".admin__field[data-index=price] input", "123.00"); // stepKey: fillProductPriceFillProductForm
		$I->fillField(".admin__field[data-index=qty] input", "100"); // stepKey: fillProductQtyFillProductForm
		$I->selectOption("select[name='product[quantity_and_stock_status][is_in_stock]']", "1"); // stepKey: selectStockStatusFillProductForm
		$I->waitForPageLoad(30); // stepKey: selectStockStatusFillProductFormWaitForPageLoad
		$I->selectOption("select[name='product[product_has_weight]']", "This item has weight"); // stepKey: selectWeightFillProductForm
		$I->fillField(".admin__field[data-index=weight] input", "1"); // stepKey: fillProductWeightFillProductForm
		$I->comment("Exiting Action Group [fillProductForm] FillMainProductFormActionGroup");
		$I->comment("Entering Action Group [saveProductForm] SaveProductFormActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollTopPageProductSaveProductForm
		$I->waitForElementVisible("#save-button", 30); // stepKey: waitForSaveProductButtonSaveProductForm
		$I->waitForPageLoad(30); // stepKey: waitForSaveProductButtonSaveProductFormWaitForPageLoad
		$I->click("#save-button"); // stepKey: clickSaveProductSaveProductForm
		$I->waitForPageLoad(30); // stepKey: clickSaveProductSaveProductFormWaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitProductSaveSuccessMessageSaveProductForm
		$I->dontSee(".message-warning"); // stepKey: dontSeeWarningMessageSaveProductForm
		$I->see("You saved the product.", "#messages div.message-success"); // stepKey: seeSaveConfirmationSaveProductForm
		$I->comment("Exiting Action Group [saveProductForm] SaveProductFormActionGroup");
		$I->comment("Assert product attribute on Storefront");
		$I->comment("Entering Action Group [openProductPage] OpenStorefrontProductPageByProductNameActionGroup");
		$I->amOnPage("testProductName" . msq("_defaultProduct") . ".html"); // stepKey: amOnProductPageOpenProductPage
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadOpenProductPage
		$I->comment("Exiting Action Group [openProductPage] OpenStorefrontProductPageByProductNameActionGroup");
		$I->scrollTo("#product-attribute-specs-table"); // stepKey: scrollToMoreInformation
		$I->comment("Entering Action Group [checkAttributeInMoreInformationTab] AssertStorefrontCustomProductAttributeActionGroup");
		$I->see("attribute" . msq("productTextEditorAttribute"), "//th[./following-sibling::td[@data-th='attribute" . msq("productTextEditorAttribute") . "']]"); // stepKey: seeAttributeLabelCheckAttributeInMoreInformationTab
		$I->see("This content from product page", "//td[@data-th='attribute" . msq("productTextEditorAttribute") . "']"); // stepKey: seeAttributeValueCheckAttributeInMoreInformationTab
		$I->comment("Exiting Action Group [checkAttributeInMoreInformationTab] AssertStorefrontCustomProductAttributeActionGroup");
	}
}
