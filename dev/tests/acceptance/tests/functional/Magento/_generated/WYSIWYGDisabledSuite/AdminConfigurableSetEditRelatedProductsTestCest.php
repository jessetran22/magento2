<?php
namespace Magento\AcceptanceTest\_WYSIWYGDisabledSuite\Backend;

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
 * @Title("MC-3414: Admin should be able to set/edit Related Products information when editing a configurable product")
 * @Description("Admin should be able to set/edit Related Products information when editing a configurable product<h3>Test files</h3>app/code/Magento/ConfigurableProduct/Test/Mftf/Test/AdminConfigurableSetEditRelatedProductsTest.xml<br>")
 * @TestCaseId("MC-3414")
 * @group ConfigurableProduct
 * @group WYSIWYGDisabled
 */
class AdminConfigurableSetEditRelatedProductsTestCest
{
	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _before(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin
		$I->comment("Exiting Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->createEntity("simpleProduct0", "hook", "SimpleProduct2", [], []); // stepKey: simpleProduct0
		$I->createEntity("simpleProduct1", "hook", "SimpleProduct2", [], []); // stepKey: simpleProduct1
		$I->createEntity("simpleProduct2", "hook", "SimpleProduct2", [], []); // stepKey: simpleProduct2
		$I->createEntity("simpleProduct3", "hook", "SimpleProduct2", [], []); // stepKey: simpleProduct3
		$I->createEntity("simpleProduct4", "hook", "SimpleProduct2", [], []); // stepKey: simpleProduct4
		$I->createEntity("simpleProduct5", "hook", "SimpleProduct2", [], []); // stepKey: simpleProduct5
		$I->createEntity("simpleProduct6", "hook", "SimpleProduct2", [], []); // stepKey: simpleProduct6
		$runCronIndexer = $I->magentoCLI("cron:run --group=index", 60); // stepKey: runCronIndexer
		$I->comment($runCronIndexer);
		$I->createEntity("createCategory", "hook", "ApiCategory", [], []); // stepKey: createCategory
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Delete simple product");
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
		$I->comment("Entering Action Group [clearProductsGridFilters] ClearFiltersAdminDataGridActionGroup");
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clearExistingOrderFiltersClearProductsGridFilters
		$I->waitForPageLoad(30); // stepKey: clearExistingOrderFiltersClearProductsGridFiltersWaitForPageLoad
		$I->comment("Exiting Action Group [clearProductsGridFilters] ClearFiltersAdminDataGridActionGroup");
		$I->comment("Entering Action Group [amOnLogoutPage] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageAmOnLogoutPage
		$I->comment("Exiting Action Group [amOnLogoutPage] AdminLogoutActionGroup");
		$I->deleteEntity("simpleProduct0", "hook"); // stepKey: deleteSimpleProduct0
		$I->deleteEntity("simpleProduct1", "hook"); // stepKey: deleteSimpleProduct1
		$I->deleteEntity("simpleProduct2", "hook"); // stepKey: deleteSimpleProduct2
		$I->deleteEntity("simpleProduct3", "hook"); // stepKey: deleteSimpleProduct3
		$I->deleteEntity("simpleProduct4", "hook"); // stepKey: deleteSimpleProduct4
		$I->deleteEntity("simpleProduct5", "hook"); // stepKey: deleteSimpleProduct5
		$I->deleteEntity("simpleProduct6", "hook"); // stepKey: deleteSimpleProduct6
		$I->comment("Delete configurable product");
		$I->deleteEntity("createCategory", "hook"); // stepKey: deleteCategory
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
	 * @Features({"ConfigurableProduct"})
	 * @Stories({"Create/Edit configurable product"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminConfigurableSetEditRelatedProductsTest(AcceptanceTester $I)
	{
		$I->comment("Create product");
		$I->comment("Entering Action Group [navigateToProductIndex] AdminOpenProductIndexPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: goToProductIndexPageNavigateToProductIndex
		$I->waitForPageLoad(30); // stepKey: waitForProductIndexPageLoadNavigateToProductIndex
		$I->comment("Exiting Action Group [navigateToProductIndex] AdminOpenProductIndexPageActionGroup");
		$I->comment("Entering Action Group [fillProductForm] CreateConfigurableProductActionGroup");
		$I->comment("fill in basic configurable product values");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: amOnProductGridPageFillProductForm
		$I->waitForPageLoad(30); // stepKey: wait1FillProductForm
		$I->click(".action-toggle.primary.add"); // stepKey: clickOnAddProductToggleFillProductForm
		$I->waitForPageLoad(30); // stepKey: clickOnAddProductToggleFillProductFormWaitForPageLoad
		$I->click(".item[data-ui-id='products-list-add-new-product-button-item-configurable']"); // stepKey: clickOnAddConfigurableProductFillProductForm
		$I->waitForPageLoad(30); // stepKey: clickOnAddConfigurableProductFillProductFormWaitForPageLoad
		$I->fillField(".admin__field[data-index=name] input", "testProductName" . msq("_defaultProduct")); // stepKey: fillNameFillProductForm
		$I->fillField(".admin__field[data-index=sku] input", "testSku" . msq("_defaultProduct")); // stepKey: fillSKUFillProductForm
		$I->fillField(".admin__field[data-index=price] input", "123.00"); // stepKey: fillPriceFillProductForm
		$I->fillField(".admin__field[data-index=qty] input", "100"); // stepKey: fillQuantityFillProductForm
		$I->searchAndMultiSelectOption("div[data-index='category_ids']", [$I->retrieveEntityField('createCategory', 'name', 'test')]); // stepKey: fillCategoryFillProductForm
		$I->waitForPageLoad(30); // stepKey: fillCategoryFillProductFormWaitForPageLoad
		$I->selectOption("//select[@name='product[visibility]']", "4"); // stepKey: fillVisibilityFillProductForm
		$I->click("div[data-index='search-engine-optimization']"); // stepKey: openSeoSectionFillProductForm
		$I->waitForPageLoad(30); // stepKey: openSeoSectionFillProductFormWaitForPageLoad
		$I->fillField("input[name='product[url_key]']", "testproductname" . msq("_defaultProduct")); // stepKey: fillUrlKeyFillProductForm
		$I->comment("create configurations for colors the product is available in");
		$I->click("button[data-index='create_configurable_products_button']"); // stepKey: clickOnCreateConfigurationsFillProductForm
		$I->waitForPageLoad(30); // stepKey: clickOnCreateConfigurationsFillProductFormWaitForPageLoad
		$I->click(".select-attributes-actions button[title='Create New Attribute']"); // stepKey: clickOnNewAttributeFillProductForm
		$I->waitForPageLoad(30); // stepKey: clickOnNewAttributeFillProductFormWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForIFrameFillProductForm
		$I->switchToIFrame("create_new_attribute_container"); // stepKey: switchToNewAttributeIFrameFillProductForm
		$I->fillField("input[name='frontend_label[0]']", "Color" . msq("colorProductAttribute")); // stepKey: fillDefaultLabelFillProductForm
		$I->click("#save"); // stepKey: clickOnNewAttributePanelFillProductForm
		$I->waitForPageLoad(30); // stepKey: waitForSaveAttributeFillProductForm
		$I->switchToIFrame(); // stepKey: switchOutOfIFrameFillProductForm
		$I->waitForPageLoad(30); // stepKey: waitForFiltersFillProductForm
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: clickOnFiltersFillProductForm
		$I->fillField(".admin__control-text[name='attribute_code']", "Color" . msq("colorProductAttribute")); // stepKey: fillFilterAttributeCodeFieldFillProductForm
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersButtonFillProductForm
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersButtonFillProductFormWaitForPageLoad
		$I->click("tr[data-repeat-index='0'] .admin__control-checkbox"); // stepKey: clickOnFirstCheckboxFillProductForm
		$I->click(".steps-wizard-navigation .action-next-step"); // stepKey: clickOnNextButton1FillProductForm
		$I->waitForPageLoad(30); // stepKey: clickOnNextButton1FillProductFormWaitForPageLoad
		$I->waitForElementVisible(".action-create-new", 30); // stepKey: waitCreateNewValueAppearsFillProductForm
		$I->waitForPageLoad(30); // stepKey: waitCreateNewValueAppearsFillProductFormWaitForPageLoad
		$I->click(".action-create-new"); // stepKey: clickOnCreateNewValue1FillProductForm
		$I->waitForPageLoad(30); // stepKey: clickOnCreateNewValue1FillProductFormWaitForPageLoad
		$I->fillField("li[data-attribute-option-title=''] .admin__field-create-new .admin__control-text", "White" . msq("colorProductAttribute1")); // stepKey: fillFieldForNewAttribute1FillProductForm
		$I->click("li[data-attribute-option-title=''] .action-save"); // stepKey: clickOnSaveNewAttribute1FillProductForm
		$I->waitForPageLoad(30); // stepKey: clickOnSaveNewAttribute1FillProductFormWaitForPageLoad
		$I->click(".action-create-new"); // stepKey: clickOnCreateNewValue2FillProductForm
		$I->waitForPageLoad(30); // stepKey: clickOnCreateNewValue2FillProductFormWaitForPageLoad
		$I->fillField("li[data-attribute-option-title=''] .admin__field-create-new .admin__control-text", "Red" . msq("colorProductAttribute2")); // stepKey: fillFieldForNewAttribute2FillProductForm
		$I->click("li[data-attribute-option-title=''] .action-save"); // stepKey: clickOnSaveNewAttribute2FillProductForm
		$I->waitForPageLoad(30); // stepKey: clickOnSaveNewAttribute2FillProductFormWaitForPageLoad
		$I->click(".action-create-new"); // stepKey: clickOnCreateNewValue3FillProductForm
		$I->waitForPageLoad(30); // stepKey: clickOnCreateNewValue3FillProductFormWaitForPageLoad
		$I->fillField("li[data-attribute-option-title=''] .admin__field-create-new .admin__control-text", "Blue" . msq("colorProductAttribute3")); // stepKey: fillFieldForNewAttribute3FillProductForm
		$I->click("li[data-attribute-option-title=''] .action-save"); // stepKey: clickOnSaveNewAttribute3FillProductForm
		$I->waitForPageLoad(30); // stepKey: clickOnSaveNewAttribute3FillProductFormWaitForPageLoad
		$I->click(".action-select-all"); // stepKey: clickOnSelectAllFillProductForm
		$I->click(".steps-wizard-navigation .action-next-step"); // stepKey: clickOnNextButton2FillProductForm
		$I->waitForPageLoad(30); // stepKey: clickOnNextButton2FillProductFormWaitForPageLoad
		$I->click(".admin__field-label[for='apply-unique-prices-radio']"); // stepKey: clickOnApplyUniquePricesByAttributeToEachSkuFillProductForm
		$I->selectOption("#select-each-price", "Color" . msq("colorProductAttribute")); // stepKey: selectAttributesFillProductForm
		$I->waitForPageLoad(30); // stepKey: selectAttributesFillProductFormWaitForPageLoad
		$I->fillField("#apply-single-price-input-0", "1.00"); // stepKey: fillAttributePrice1FillProductForm
		$I->fillField("#apply-single-price-input-1", "2.00"); // stepKey: fillAttributePrice2FillProductForm
		$I->fillField("#apply-single-price-input-2", "3.00"); // stepKey: fillAttributePrice3FillProductForm
		$I->click(".admin__field-label[for='apply-single-inventory-radio']"); // stepKey: clickOnApplySingleQuantityToEachSkuFillProductForm
		$I->waitForPageLoad(30); // stepKey: clickOnApplySingleQuantityToEachSkuFillProductFormWaitForPageLoad
		$I->fillField("#apply-single-inventory-input", "1"); // stepKey: enterAttributeQuantityFillProductForm
		$I->click(".steps-wizard-navigation .action-next-step"); // stepKey: clickOnNextButton3FillProductForm
		$I->waitForPageLoad(30); // stepKey: clickOnNextButton3FillProductFormWaitForPageLoad
		$I->click(".steps-wizard-navigation .action-next-step"); // stepKey: clickOnNextButton4FillProductForm
		$I->waitForPageLoad(30); // stepKey: clickOnNextButton4FillProductFormWaitForPageLoad
		$I->click("#save-button"); // stepKey: clickOnSaveButton2FillProductForm
		$I->waitForPageLoad(30); // stepKey: clickOnSaveButton2FillProductFormWaitForPageLoad
		$I->click("button[data-index='confirm_button']"); // stepKey: clickOnConfirmInPopupFillProductForm
		$I->waitForPageLoad(30); // stepKey: clickOnConfirmInPopupFillProductFormWaitForPageLoad
		$I->seeElement(".message.message-success.success"); // stepKey: seeSaveProductMessageFillProductForm
		$I->seeInTitle("testProductName" . msq("_defaultProduct")); // stepKey: seeProductNameInTitleFillProductForm
		$I->comment("Exiting Action Group [fillProductForm] CreateConfigurableProductActionGroup");
		$I->comment("Add related product");
		$I->comment("Entering Action Group [addRelatedProduct0] AddRelatedProductBySkuActionGroup");
		$I->comment("Scroll up to avoid error");
		$I->scrollTo("//div[@data-index='related']", 0, -100); // stepKey: scrollToAddRelatedProduct0
		$I->waitForPageLoad(30); // stepKey: scrollToAddRelatedProduct0WaitForPageLoad
		$I->conditionalClick("//div[@data-index='related']", "//div[@data-index='related']//div[contains(@class, '_show')]", false); // stepKey: openDropDownIfClosedRelatedUpSellCrossSellAddRelatedProduct0
		$I->click("button[data-index='button_related']"); // stepKey: clickAddRelatedProductButtonAddRelatedProduct0
		$I->waitForPageLoad(30); // stepKey: clickAddRelatedProductButtonAddRelatedProduct0WaitForPageLoad
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersAddRelatedProduct0
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersAddRelatedProduct0WaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFiltersAddRelatedProduct0
		$I->fillField("input.admin__control-text[name='sku']", $I->retrieveEntityField('simpleProduct0', 'sku', 'test')); // stepKey: fillProductSkuFilterAddRelatedProduct0
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersAddRelatedProduct0
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersAddRelatedProduct0WaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadAddRelatedProduct0
		$I->click(".modal-slide table.data-grid tr.data-row:nth-child(1) td:nth-child(1)"); // stepKey: selectProductAddRelatedProduct0
		$I->waitForPageLoad(30); // stepKey: selectProductAddRelatedProduct0WaitForPageLoad
		$I->click("//aside[contains(@class, 'related_modal')]//button[contains(@class, 'action-primary')]"); // stepKey: addRelatedProductSelectedAddRelatedProduct0
		$I->waitForPageLoad(30); // stepKey: addRelatedProductSelectedAddRelatedProduct0WaitForPageLoad
		$I->waitForElementNotVisible("//aside[contains(@class, 'related_modal')]//button[contains(@class, 'action-primary')]", 30); // stepKey: waitForElementNotVisibleAddRelatedProduct0
		$I->waitForPageLoad(30); // stepKey: waitForElementNotVisibleAddRelatedProduct0WaitForPageLoad
		$I->comment("Exiting Action Group [addRelatedProduct0] AddRelatedProductBySkuActionGroup");
		$I->comment("Save the product");
		$I->comment("Entering Action Group [clickSaveButton] AdminProductFormSaveActionGroup");
		$I->click("#save-button"); // stepKey: saveProductClickSaveButton
		$I->waitForPageLoad(30); // stepKey: saveProductClickSaveButtonWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForProductSavingClickSaveButton
		$I->comment("Exiting Action Group [clickSaveButton] AdminProductFormSaveActionGroup");
		$I->see("You saved the product.", ".message-success"); // stepKey: messageYouSavedTheProductIsShown
		$I->comment("Add another related product");
		$I->comment("Entering Action Group [addRelatedProduct1] AddRelatedProductBySkuActionGroup");
		$I->comment("Scroll up to avoid error");
		$I->scrollTo("//div[@data-index='related']", 0, -100); // stepKey: scrollToAddRelatedProduct1
		$I->waitForPageLoad(30); // stepKey: scrollToAddRelatedProduct1WaitForPageLoad
		$I->conditionalClick("//div[@data-index='related']", "//div[@data-index='related']//div[contains(@class, '_show')]", false); // stepKey: openDropDownIfClosedRelatedUpSellCrossSellAddRelatedProduct1
		$I->click("button[data-index='button_related']"); // stepKey: clickAddRelatedProductButtonAddRelatedProduct1
		$I->waitForPageLoad(30); // stepKey: clickAddRelatedProductButtonAddRelatedProduct1WaitForPageLoad
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersAddRelatedProduct1
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersAddRelatedProduct1WaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFiltersAddRelatedProduct1
		$I->fillField("input.admin__control-text[name='sku']", $I->retrieveEntityField('simpleProduct1', 'sku', 'test')); // stepKey: fillProductSkuFilterAddRelatedProduct1
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersAddRelatedProduct1
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersAddRelatedProduct1WaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadAddRelatedProduct1
		$I->click(".modal-slide table.data-grid tr.data-row:nth-child(1) td:nth-child(1)"); // stepKey: selectProductAddRelatedProduct1
		$I->waitForPageLoad(30); // stepKey: selectProductAddRelatedProduct1WaitForPageLoad
		$I->click("//aside[contains(@class, 'related_modal')]//button[contains(@class, 'action-primary')]"); // stepKey: addRelatedProductSelectedAddRelatedProduct1
		$I->waitForPageLoad(30); // stepKey: addRelatedProductSelectedAddRelatedProduct1WaitForPageLoad
		$I->waitForElementNotVisible("//aside[contains(@class, 'related_modal')]//button[contains(@class, 'action-primary')]", 30); // stepKey: waitForElementNotVisibleAddRelatedProduct1
		$I->waitForPageLoad(30); // stepKey: waitForElementNotVisibleAddRelatedProduct1WaitForPageLoad
		$I->comment("Exiting Action Group [addRelatedProduct1] AddRelatedProductBySkuActionGroup");
		$I->comment("Remove previous related product");
		$I->click("//span[text()='Related Products']//..//..//..//span[text()='" . $I->retrieveEntityField('simpleProduct0', 'sku', 'test') . "']//..//..//..//..//..//button[@class='action-delete']"); // stepKey: removeRelatedProduct
		$I->comment("Save the product");
		$I->comment("Entering Action Group [clickSaveButtonAfterEdit] AdminProductFormSaveActionGroup");
		$I->click("#save-button"); // stepKey: saveProductClickSaveButtonAfterEdit
		$I->waitForPageLoad(30); // stepKey: saveProductClickSaveButtonAfterEditWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForProductSavingClickSaveButtonAfterEdit
		$I->comment("Exiting Action Group [clickSaveButtonAfterEdit] AdminProductFormSaveActionGroup");
		$I->see("You saved the product.", ".message-success"); // stepKey: messageYouSavedTheProductIsShownAgain
		$I->comment("See related product in admin");
		$I->scrollTo("//div[@data-index='related']"); // stepKey: scrollTo
		$I->waitForPageLoad(30); // stepKey: scrollToWaitForPageLoad
		$I->conditionalClick("//div[@data-index='related']", "//div[@data-index='related']//div[contains(@class, '_show')]", false); // stepKey: openDropDownIfClosedRelatedSee
		$I->see($I->retrieveEntityField('simpleProduct1', 'name', 'test'), "//span[@data-index='name']"); // stepKey: seeRelatedProduct
		$I->comment("See more related products in admin");
		$I->comment("Entering Action Group [addRelatedProduct2] AddRelatedProductBySkuActionGroup");
		$I->comment("Scroll up to avoid error");
		$I->scrollTo("//div[@data-index='related']", 0, -100); // stepKey: scrollToAddRelatedProduct2
		$I->waitForPageLoad(30); // stepKey: scrollToAddRelatedProduct2WaitForPageLoad
		$I->conditionalClick("//div[@data-index='related']", "//div[@data-index='related']//div[contains(@class, '_show')]", false); // stepKey: openDropDownIfClosedRelatedUpSellCrossSellAddRelatedProduct2
		$I->click("button[data-index='button_related']"); // stepKey: clickAddRelatedProductButtonAddRelatedProduct2
		$I->waitForPageLoad(30); // stepKey: clickAddRelatedProductButtonAddRelatedProduct2WaitForPageLoad
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersAddRelatedProduct2
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersAddRelatedProduct2WaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFiltersAddRelatedProduct2
		$I->fillField("input.admin__control-text[name='sku']", $I->retrieveEntityField('simpleProduct2', 'sku', 'test')); // stepKey: fillProductSkuFilterAddRelatedProduct2
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersAddRelatedProduct2
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersAddRelatedProduct2WaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadAddRelatedProduct2
		$I->click(".modal-slide table.data-grid tr.data-row:nth-child(1) td:nth-child(1)"); // stepKey: selectProductAddRelatedProduct2
		$I->waitForPageLoad(30); // stepKey: selectProductAddRelatedProduct2WaitForPageLoad
		$I->click("//aside[contains(@class, 'related_modal')]//button[contains(@class, 'action-primary')]"); // stepKey: addRelatedProductSelectedAddRelatedProduct2
		$I->waitForPageLoad(30); // stepKey: addRelatedProductSelectedAddRelatedProduct2WaitForPageLoad
		$I->waitForElementNotVisible("//aside[contains(@class, 'related_modal')]//button[contains(@class, 'action-primary')]", 30); // stepKey: waitForElementNotVisibleAddRelatedProduct2
		$I->waitForPageLoad(30); // stepKey: waitForElementNotVisibleAddRelatedProduct2WaitForPageLoad
		$I->comment("Exiting Action Group [addRelatedProduct2] AddRelatedProductBySkuActionGroup");
		$I->comment("Entering Action Group [addRelatedProduct3] AddRelatedProductBySkuActionGroup");
		$I->comment("Scroll up to avoid error");
		$I->scrollTo("//div[@data-index='related']", 0, -100); // stepKey: scrollToAddRelatedProduct3
		$I->waitForPageLoad(30); // stepKey: scrollToAddRelatedProduct3WaitForPageLoad
		$I->conditionalClick("//div[@data-index='related']", "//div[@data-index='related']//div[contains(@class, '_show')]", false); // stepKey: openDropDownIfClosedRelatedUpSellCrossSellAddRelatedProduct3
		$I->click("button[data-index='button_related']"); // stepKey: clickAddRelatedProductButtonAddRelatedProduct3
		$I->waitForPageLoad(30); // stepKey: clickAddRelatedProductButtonAddRelatedProduct3WaitForPageLoad
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersAddRelatedProduct3
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersAddRelatedProduct3WaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFiltersAddRelatedProduct3
		$I->fillField("input.admin__control-text[name='sku']", $I->retrieveEntityField('simpleProduct3', 'sku', 'test')); // stepKey: fillProductSkuFilterAddRelatedProduct3
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersAddRelatedProduct3
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersAddRelatedProduct3WaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadAddRelatedProduct3
		$I->click(".modal-slide table.data-grid tr.data-row:nth-child(1) td:nth-child(1)"); // stepKey: selectProductAddRelatedProduct3
		$I->waitForPageLoad(30); // stepKey: selectProductAddRelatedProduct3WaitForPageLoad
		$I->click("//aside[contains(@class, 'related_modal')]//button[contains(@class, 'action-primary')]"); // stepKey: addRelatedProductSelectedAddRelatedProduct3
		$I->waitForPageLoad(30); // stepKey: addRelatedProductSelectedAddRelatedProduct3WaitForPageLoad
		$I->waitForElementNotVisible("//aside[contains(@class, 'related_modal')]//button[contains(@class, 'action-primary')]", 30); // stepKey: waitForElementNotVisibleAddRelatedProduct3
		$I->waitForPageLoad(30); // stepKey: waitForElementNotVisibleAddRelatedProduct3WaitForPageLoad
		$I->comment("Exiting Action Group [addRelatedProduct3] AddRelatedProductBySkuActionGroup");
		$I->comment("Entering Action Group [addRelatedProduct4] AddRelatedProductBySkuActionGroup");
		$I->comment("Scroll up to avoid error");
		$I->scrollTo("//div[@data-index='related']", 0, -100); // stepKey: scrollToAddRelatedProduct4
		$I->waitForPageLoad(30); // stepKey: scrollToAddRelatedProduct4WaitForPageLoad
		$I->conditionalClick("//div[@data-index='related']", "//div[@data-index='related']//div[contains(@class, '_show')]", false); // stepKey: openDropDownIfClosedRelatedUpSellCrossSellAddRelatedProduct4
		$I->click("button[data-index='button_related']"); // stepKey: clickAddRelatedProductButtonAddRelatedProduct4
		$I->waitForPageLoad(30); // stepKey: clickAddRelatedProductButtonAddRelatedProduct4WaitForPageLoad
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersAddRelatedProduct4
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersAddRelatedProduct4WaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFiltersAddRelatedProduct4
		$I->fillField("input.admin__control-text[name='sku']", $I->retrieveEntityField('simpleProduct4', 'sku', 'test')); // stepKey: fillProductSkuFilterAddRelatedProduct4
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersAddRelatedProduct4
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersAddRelatedProduct4WaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadAddRelatedProduct4
		$I->click(".modal-slide table.data-grid tr.data-row:nth-child(1) td:nth-child(1)"); // stepKey: selectProductAddRelatedProduct4
		$I->waitForPageLoad(30); // stepKey: selectProductAddRelatedProduct4WaitForPageLoad
		$I->click("//aside[contains(@class, 'related_modal')]//button[contains(@class, 'action-primary')]"); // stepKey: addRelatedProductSelectedAddRelatedProduct4
		$I->waitForPageLoad(30); // stepKey: addRelatedProductSelectedAddRelatedProduct4WaitForPageLoad
		$I->waitForElementNotVisible("//aside[contains(@class, 'related_modal')]//button[contains(@class, 'action-primary')]", 30); // stepKey: waitForElementNotVisibleAddRelatedProduct4
		$I->waitForPageLoad(30); // stepKey: waitForElementNotVisibleAddRelatedProduct4WaitForPageLoad
		$I->comment("Exiting Action Group [addRelatedProduct4] AddRelatedProductBySkuActionGroup");
		$I->comment("Entering Action Group [addRelatedProduct5] AddRelatedProductBySkuActionGroup");
		$I->comment("Scroll up to avoid error");
		$I->scrollTo("//div[@data-index='related']", 0, -100); // stepKey: scrollToAddRelatedProduct5
		$I->waitForPageLoad(30); // stepKey: scrollToAddRelatedProduct5WaitForPageLoad
		$I->conditionalClick("//div[@data-index='related']", "//div[@data-index='related']//div[contains(@class, '_show')]", false); // stepKey: openDropDownIfClosedRelatedUpSellCrossSellAddRelatedProduct5
		$I->click("button[data-index='button_related']"); // stepKey: clickAddRelatedProductButtonAddRelatedProduct5
		$I->waitForPageLoad(30); // stepKey: clickAddRelatedProductButtonAddRelatedProduct5WaitForPageLoad
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersAddRelatedProduct5
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersAddRelatedProduct5WaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFiltersAddRelatedProduct5
		$I->fillField("input.admin__control-text[name='sku']", $I->retrieveEntityField('simpleProduct5', 'sku', 'test')); // stepKey: fillProductSkuFilterAddRelatedProduct5
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersAddRelatedProduct5
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersAddRelatedProduct5WaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadAddRelatedProduct5
		$I->click(".modal-slide table.data-grid tr.data-row:nth-child(1) td:nth-child(1)"); // stepKey: selectProductAddRelatedProduct5
		$I->waitForPageLoad(30); // stepKey: selectProductAddRelatedProduct5WaitForPageLoad
		$I->click("//aside[contains(@class, 'related_modal')]//button[contains(@class, 'action-primary')]"); // stepKey: addRelatedProductSelectedAddRelatedProduct5
		$I->waitForPageLoad(30); // stepKey: addRelatedProductSelectedAddRelatedProduct5WaitForPageLoad
		$I->waitForElementNotVisible("//aside[contains(@class, 'related_modal')]//button[contains(@class, 'action-primary')]", 30); // stepKey: waitForElementNotVisibleAddRelatedProduct5
		$I->waitForPageLoad(30); // stepKey: waitForElementNotVisibleAddRelatedProduct5WaitForPageLoad
		$I->comment("Exiting Action Group [addRelatedProduct5] AddRelatedProductBySkuActionGroup");
		$I->comment("Entering Action Group [addRelatedProduct6] AddRelatedProductBySkuActionGroup");
		$I->comment("Scroll up to avoid error");
		$I->scrollTo("//div[@data-index='related']", 0, -100); // stepKey: scrollToAddRelatedProduct6
		$I->waitForPageLoad(30); // stepKey: scrollToAddRelatedProduct6WaitForPageLoad
		$I->conditionalClick("//div[@data-index='related']", "//div[@data-index='related']//div[contains(@class, '_show')]", false); // stepKey: openDropDownIfClosedRelatedUpSellCrossSellAddRelatedProduct6
		$I->click("button[data-index='button_related']"); // stepKey: clickAddRelatedProductButtonAddRelatedProduct6
		$I->waitForPageLoad(30); // stepKey: clickAddRelatedProductButtonAddRelatedProduct6WaitForPageLoad
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersAddRelatedProduct6
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersAddRelatedProduct6WaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFiltersAddRelatedProduct6
		$I->fillField("input.admin__control-text[name='sku']", $I->retrieveEntityField('simpleProduct6', 'sku', 'test')); // stepKey: fillProductSkuFilterAddRelatedProduct6
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersAddRelatedProduct6
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersAddRelatedProduct6WaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadAddRelatedProduct6
		$I->click(".modal-slide table.data-grid tr.data-row:nth-child(1) td:nth-child(1)"); // stepKey: selectProductAddRelatedProduct6
		$I->waitForPageLoad(30); // stepKey: selectProductAddRelatedProduct6WaitForPageLoad
		$I->click("//aside[contains(@class, 'related_modal')]//button[contains(@class, 'action-primary')]"); // stepKey: addRelatedProductSelectedAddRelatedProduct6
		$I->waitForPageLoad(30); // stepKey: addRelatedProductSelectedAddRelatedProduct6WaitForPageLoad
		$I->waitForElementNotVisible("//aside[contains(@class, 'related_modal')]//button[contains(@class, 'action-primary')]", 30); // stepKey: waitForElementNotVisibleAddRelatedProduct6
		$I->waitForPageLoad(30); // stepKey: waitForElementNotVisibleAddRelatedProduct6WaitForPageLoad
		$I->comment("Exiting Action Group [addRelatedProduct6] AddRelatedProductBySkuActionGroup");
		$I->scrollTo("//div[@data-index='related']"); // stepKey: scrollTo2
		$I->waitForPageLoad(30); // stepKey: scrollTo2WaitForPageLoad
		$I->conditionalClick("//div[@data-index='related']", "//div[@data-index='related']//div[contains(@class, '_show')]", false); // stepKey: openDropDownIfClosedRelatedSee2
		$I->see($I->retrieveEntityField('simpleProduct6', 'name', 'test'), "//span[@data-index='name']"); // stepKey: seeSixthRelatedProduct
		$I->selectOption(".admin__collapsible-block-wrapper[data-index='related'] .admin__control-select", "5"); // stepKey: selectFivePerPage
		$I->waitForPageLoad(30); // stepKey: waitForLoadingAfterSelectFivePerPage
		$I->dontSee($I->retrieveEntityField('simpleProduct6', 'name', 'test'), "//span[@data-index='name']"); // stepKey: dontSeeSixthRelatedProduct
		$I->comment("See related product in storefront");
		$I->amOnPage("testproductname" . msq("_defaultProduct") . ".html"); // stepKey: goToStorefront
		$I->waitForPageLoad(30); // stepKey: waitForStorefront
		$I->seeElement("//*[@class='block related']//a[contains(text(), '" . $I->retrieveEntityField('simpleProduct1', 'name', 'test') . "')]"); // stepKey: seeRelatedProductInStorefront
		$I->comment("Create product");
		$I->comment("See related product in storefront");
	}
}
