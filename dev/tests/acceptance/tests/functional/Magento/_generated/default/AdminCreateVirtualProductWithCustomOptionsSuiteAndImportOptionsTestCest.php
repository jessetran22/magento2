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
 * @Title("MC-6034: Create virtual product with custom options suite and import options")
 * @Description("Test log in to Create virtual product and Create virtual product with custom options suite and import options<h3>Test files</h3>app/code/Magento/Catalog/Test/Mftf/Test/AdminCreateVirtualProductWithCustomOptionsSuiteAndImportOptionsTest.xml<br>")
 * @TestCaseId("MC-6034")
 * @group catalog
 * @group mtf_migrated
 */
class AdminCreateVirtualProductWithCustomOptionsSuiteAndImportOptionsTestCest
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
		$I->createEntity("categoryEntity", "hook", "SimpleSubCategory", [], []); // stepKey: categoryEntity
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
		$I->deleteEntity("categoryEntity", "hook"); // stepKey: deleteSimpleSubCategory
		$I->comment("Entering Action Group [deleteVirtualProduct] DeleteProductBySkuActionGroup");
		$I->comment("TODO use other action group for filtering grid when MQE-539 is implemented");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: visitAdminProductPageDeleteVirtualProduct
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersDeleteVirtualProduct
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersDeleteVirtualProductWaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFiltersDeleteVirtualProduct
		$I->fillField("input.admin__control-text[name='sku']", "virtual_sku" . msq("virtualProductCustomImportOptions")); // stepKey: fillProductSkuFilterDeleteVirtualProduct
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersDeleteVirtualProduct
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersDeleteVirtualProductWaitForPageLoad
		$I->see("virtual_sku" . msq("virtualProductCustomImportOptions"), "//tr[1]//td[count(//div[@data-role='grid-wrapper']//tr//th[normalize-space(.)='SKU']/preceding-sibling::th) +1 ]"); // stepKey: seeProductSkuInGridDeleteVirtualProduct
		$I->click("div[data-role='grid-wrapper'] th.data-grid-multicheck-cell button.action-multicheck-toggle"); // stepKey: openMulticheckDropdownDeleteVirtualProduct
		$I->click("//div[@data-role='grid-wrapper']//th[contains(@class, data-grid-multicheck-cell)]//li//span[text() = 'Select All']"); // stepKey: selectAllProductInFilteredGridDeleteVirtualProduct
		$I->click("div.admin__data-grid-header-row.row div.action-select-wrap button.action-select"); // stepKey: clickActionDropdownDeleteVirtualProduct
		$I->waitForPageLoad(30); // stepKey: clickActionDropdownDeleteVirtualProductWaitForPageLoad
		$I->click("//div[contains(@class,'admin__data-grid-header-row') and contains(@class, 'row')]//div[contains(@class, 'action-select-wrap')]//ul/li/span[text() = 'Delete']"); // stepKey: clickDeleteActionDeleteVirtualProduct
		$I->waitForPageLoad(30); // stepKey: clickDeleteActionDeleteVirtualProductWaitForPageLoad
		$I->waitForElementVisible("aside.confirm .modal-footer button.action-accept", 30); // stepKey: waitForConfirmModalDeleteVirtualProduct
		$I->waitForPageLoad(60); // stepKey: waitForConfirmModalDeleteVirtualProductWaitForPageLoad
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: confirmProductDeleteDeleteVirtualProduct
		$I->waitForPageLoad(60); // stepKey: confirmProductDeleteDeleteVirtualProductWaitForPageLoad
		$I->see("record(s) have been deleted.", "#messages div.message-success"); // stepKey: seeSuccessMessageDeleteVirtualProduct
		$I->comment("Exiting Action Group [deleteVirtualProduct] DeleteProductBySkuActionGroup");
		$I->comment("Entering Action Group [resetOrderFilter] ClearFiltersAdminDataGridActionGroup");
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clearExistingOrderFiltersResetOrderFilter
		$I->waitForPageLoad(30); // stepKey: clearExistingOrderFiltersResetOrderFilterWaitForPageLoad
		$I->comment("Exiting Action Group [resetOrderFilter] ClearFiltersAdminDataGridActionGroup");
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
	 * @Stories({"Create virtual product"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Features({"Catalog"})
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminCreateVirtualProductWithCustomOptionsSuiteAndImportOptionsTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [openProductCatalogPage] AdminProductCatalogPageOpenActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/"); // stepKey: openProductCatalogPageOpenProductCatalogPage
		$I->waitForPageLoad(30); // stepKey: waitForProductCatalogPageLoadOpenProductCatalogPage
		$I->comment("Exiting Action Group [openProductCatalogPage] AdminProductCatalogPageOpenActionGroup");
		$I->comment("Adding the comment to replace clickAddProductToggle action for preserving Backward Compatibility");
		$I->comment("Adding the comment to replace clickAddProductToggle action for preserving Backward Compatibility");
		$I->comment("Entering Action Group [clickVirtualProduct] AdminClickAddProductToggleAndSelectProductTypeActionGroup");
		$I->click(".action-toggle.primary.add"); // stepKey: clickAddProductDropdownClickVirtualProduct
		$I->waitForPageLoad(30); // stepKey: clickAddProductDropdownClickVirtualProductWaitForPageLoad
		$I->click(".item[data-ui-id='products-list-add-new-product-button-item-virtual']"); // stepKey: clickAddProductClickVirtualProduct
		$I->waitForPageLoad(30); // stepKey: waitForFormToLoadClickVirtualProduct
		$I->comment("Exiting Action Group [clickVirtualProduct] AdminClickAddProductToggleAndSelectProductTypeActionGroup");
		$I->comment("Create virtual product with custom options suite and import options");
		$I->fillField(".admin__field[data-index=name] input", "VirtualProduct" . msq("virtualProductCustomImportOptions")); // stepKey: fillProductName
		$I->fillField(".admin__field[data-index=sku] input", "virtual_sku" . msq("virtualProductCustomImportOptions")); // stepKey: fillProductSku
		$I->fillField(".admin__field[data-index=price] input", "9,000.00"); // stepKey: fillProductPrice
		$I->fillField(".admin__field[data-index=qty] input", "999"); // stepKey: fillProductQuantity
		$I->click("select[name='product[quantity_and_stock_status][is_in_stock]']"); // stepKey: clickProductStockStatus
		$I->waitForPageLoad(30); // stepKey: clickProductStockStatusWaitForPageLoad
		$I->click("div[data-index='category_ids']"); // stepKey: clickCategoriesDropDown
		$I->waitForPageLoad(30); // stepKey: clickCategoriesDropDownWaitForPageLoad
		$I->fillField("//*[@data-index='category_ids']//input[contains(@class, 'multiselect-search')]", $I->retrieveEntityField('categoryEntity', 'name', 'test')); // stepKey: fillSearchCategory
		$I->waitForPageLoad(30); // stepKey: fillSearchCategoryWaitForPageLoad
		$I->click("//*[@data-index='category_ids']//label[contains(., '" . $I->retrieveEntityField('categoryEntity', 'name', 'test') . "')]"); // stepKey: clickOnCategory
		$I->waitForPageLoad(30); // stepKey: clickOnCategoryWaitForPageLoad
		$I->comment("Entering Action Group [clickOnDoneAdvancedCategorySelect] AdminSubmitCategoriesPopupActionGroup");
		$I->click("//*[@data-index='category_ids']//button[@data-action='close-advanced-select']"); // stepKey: clickOnDoneButtonClickOnDoneAdvancedCategorySelect
		$I->waitForPageLoad(30); // stepKey: clickOnDoneButtonClickOnDoneAdvancedCategorySelectWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCategoryApplyClickOnDoneAdvancedCategorySelect
		$I->comment("Exiting Action Group [clickOnDoneAdvancedCategorySelect] AdminSubmitCategoriesPopupActionGroup");
		$I->click("div[data-index='search-engine-optimization']"); // stepKey: clickAdminProductSEOSection
		$I->waitForPageLoad(30); // stepKey: clickAdminProductSEOSectionWaitForPageLoad
		$I->fillField("input[name='product[url_key]']", "virtual-product" . msq("virtualProductCustomImportOptions")); // stepKey: fillUrlKey
		$I->click("//span[text()='Customizable Options']/parent::strong/parent::*[@data-state-collapsible='closed']"); // stepKey: clickAdminProductCustomizableOption
		$I->waitForPageLoad(30); // stepKey: clickAdminProductCustomizableOptionWaitForPageLoad
		$I->comment("Create virtual product with customizable options dataSet1");
		$I->click("button[data-index='button_add']"); // stepKey: clickAddOptionButton
		$I->waitForPageLoad(30); // stepKey: clickAddOptionButtonWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForFirstOption
		$I->fillField("input[name='product[options][0][title]']", "Test1 option " . msq("virtualProductCustomizableOption1")); // stepKey: fillOptionTitleForFirstDataSet
		$I->click("//table[@data-index='options']//tr[1]//div[@data-index='type']//div[contains(@class, 'action-select-wrap')]"); // stepKey: selectOptionTypeDropDownFirstDataSet
		$I->waitForPageLoad(30); // stepKey: selectOptionTypeDropDownFirstDataSetWaitForPageLoad
		$I->click("//table[@data-index='options']//tr[1]//div[@data-index='type']//*[contains(@class, 'action-menu-item')]//*[contains(., 'Field')]"); // stepKey: selectOptionFieldFromDropDownForFirstDataSet
		$I->waitForPageLoad(30); // stepKey: selectOptionFieldFromDropDownForFirstDataSetWaitForPageLoad
		$I->checkOption("input[name='product[options][0][is_require]']"); // stepKey: checkRequiredCheckBoxForFirstDataSet
		$I->fillField("//*[@data-index='custom_options']//*[@data-index='options']/tbody/tr//*[@name='product[options][0][price]']", "120.03"); // stepKey: fillOptionPriceForFirstDataSet
		$I->selectOption("//*[@data-index='custom_options']//*[@data-index='options']/tbody/tr//*[@name='product[options][0][price_type]']", "Fixed"); // stepKey: selectOptionPriceTypeForFirstDataSet
		$I->fillField("//*[@data-index='custom_options']//*[@data-index='options']/tbody/tr//*[@name='product[options][0][sku]']", "sku1_" . msq("virtualProductCustomizableOption1")); // stepKey: fillOptionSkuForFirstDataSet
		$I->fillField("input[name='product[options][0][max_characters]']", "45"); // stepKey: fillOptionMaxCharactersForFirstDataSet
		$I->comment("Create virtual product with customizable options dataSet2");
		$I->click("button[data-index='button_add']"); // stepKey: clickAddOptionButtonForSecondDataSet
		$I->waitForPageLoad(30); // stepKey: clickAddOptionButtonForSecondDataSetWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForSecondDataSetToLoad
		$I->fillField("input[name='product[options][1][title]']", "Test2 option " . msq("virtualProductCustomizableOption2")); // stepKey: fillOptionTitleForSecondDataSet
		$I->click("//table[@data-index='options']//tr[2]//div[@data-index='type']//div[contains(@class, 'action-select-wrap')]"); // stepKey: selectOptionTypeDropDownSecondDataSet
		$I->waitForPageLoad(30); // stepKey: selectOptionTypeDropDownSecondDataSetWaitForPageLoad
		$I->click("//table[@data-index='options']//tr[2]//div[@data-index='type']//*[contains(@class, 'action-menu-item')]//*[contains(., 'Field')]"); // stepKey: selectOptionFieldFromDropDownForSecondDataSet
		$I->waitForPageLoad(30); // stepKey: selectOptionFieldFromDropDownForSecondDataSetWaitForPageLoad
		$I->checkOption("input[name='product[options][1][is_require]']"); // stepKey: checkRequiredCheckBoxForSecondDataSet
		$I->fillField("//*[@data-index='custom_options']//*[@data-index='options']/tbody/tr//*[@name='product[options][1][price]']", "120.03"); // stepKey: fillOptionPriceForSecondDataSet
		$I->selectOption("//*[@data-index='custom_options']//*[@data-index='options']/tbody/tr//*[@name='product[options][1][price_type]']", "Fixed"); // stepKey: selectOptionPriceTypeForSecondDataSet
		$I->fillField("//*[@data-index='custom_options']//*[@data-index='options']/tbody/tr//*[@name='product[options][1][sku]']", "sku2_" . msq("virtualProductCustomizableOption2")); // stepKey: fillOptionSkuForSecondDataSet
		$I->fillField("input[name='product[options][0][max_characters]']", "45"); // stepKey: fillOptionMaxCharactersForSecondDataSet
		$I->comment("Create virtual product with customizable options dataSet3");
		$I->click("button[data-index='button_add']"); // stepKey: clickAddOptionButtonForThirdSetOfData
		$I->waitForPageLoad(30); // stepKey: clickAddOptionButtonForThirdSetOfDataWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForThirdSetOfDataToLoad
		$I->fillField("input[name='product[options][2][title]']", "Test3 option " . msq("virtualProductCustomizableOption3")); // stepKey: fillOptionTitleForThirdDataSet
		$I->click("//table[@data-index='options']//tr[3]//div[@data-index='type']//div[contains(@class, 'action-select-wrap')]"); // stepKey: selectOptionTypeDropDownForThirdDataSet
		$I->waitForPageLoad(30); // stepKey: selectOptionTypeDropDownForThirdDataSetWaitForPageLoad
		$I->click("//table[@data-index='options']//tr[3]//div[@data-index='type']//*[contains(@class, 'action-menu-item')]//*[contains(., 'Drop-down')]"); // stepKey: selectOptionFieldFromDropDownForThirdDataSet
		$I->waitForPageLoad(30); // stepKey: selectOptionFieldFromDropDownForThirdDataSetWaitForPageLoad
		$I->checkOption("input[name='product[options][2][is_require]']"); // stepKey: checkRequiredCheckBoxForThirdDataSet
		$I->click("//*[@data-index='custom_options']//*[@data-index='options']/tbody/tr[last()]//*[@data-action='add_new_row']"); // stepKey: clickAddOptionButtonForThirdDataSetToAddFirstRow
		$I->waitForPageLoad(30); // stepKey: clickAddOptionButtonForThirdDataSetToAddFirstRowWaitForPageLoad
		$I->fillField("//span[text()='Test3 option " . msq("virtualProductCustomizableOption3") . "']/parent::div/parent::div/parent::div//tbody/tr[@data-repeat-index='0']//span[text()='Title']/parent::label/parent::div/parent::div//div[@class='admin__field-control']/input", "Test3-1 " . msq("virtualProductCustomizableOption3")); // stepKey: fillOptionTitleForThirdDataSetFirstRow
		$I->fillField("//span[text()='Test3 option " . msq("virtualProductCustomizableOption3") . "']/parent::div/parent::div/parent::div//tbody/tr[@data-repeat-index='0']//span[text()='Price']/parent::label/parent::div//div[@class='admin__control-addon']/input", "110.01"); // stepKey: fillOptionPriceForThirdDataSetFirstRow
		$I->selectOption("//span[text()='Test3 option " . msq("virtualProductCustomizableOption3") . "']/parent::div/parent::div/parent::div//tbody//tr[@data-repeat-index='0']//span[text()='Price Type']/parent::label/parent::div/parent::div//select", "Percent"); // stepKey: selectOptionPriceTypeForThirdDataSetFirstRow
		$I->fillField("//span[text()='Test3 option " . msq("virtualProductCustomizableOption3") . "']/parent::div/parent::div/parent::div//tbody/tr[@data-repeat-index='0']//span[text()='SKU']/parent::label/parent::div/parent::div//div[@class='admin__field-control']/input", "sku3-1_" . msq("virtualProductCustomizableOption3")); // stepKey: fillOptionSkuForThirdDataSetFirstRow
		$I->click("//*[@data-index='custom_options']//*[@data-index='options']/tbody/tr[last()]//*[@data-action='add_new_row']"); // stepKey: clickAddOptionButtonForThirdDataSetToAddSecondRow
		$I->waitForPageLoad(30); // stepKey: clickAddOptionButtonForThirdDataSetToAddSecondRowWaitForPageLoad
		$I->fillField("//span[text()='Test3 option " . msq("virtualProductCustomizableOption3") . "']/parent::div/parent::div/parent::div//tbody/tr[@data-repeat-index='1']//span[text()='Title']/parent::label/parent::div/parent::div//div[@class='admin__field-control']/input", "Test3-2 " . msq("virtualProductCustomizableOption3")); // stepKey: fillOptionTitleForThirdDataSetSecondRow
		$I->fillField("//span[text()='Test3 option " . msq("virtualProductCustomizableOption3") . "']/parent::div/parent::div/parent::div//tbody/tr[@data-repeat-index='1']//span[text()='Price']/parent::label/parent::div//div[@class='admin__control-addon']/input", "210.02"); // stepKey: fillOptionPriceForThirdDataSetSecondRow
		$I->selectOption("//span[text()='Test3 option " . msq("virtualProductCustomizableOption3") . "']/parent::div/parent::div/parent::div//tbody//tr[@data-repeat-index='1']//span[text()='Price Type']/parent::label/parent::div/parent::div//select", "Fixed"); // stepKey: selectOptionPriceTypeForThirdDataSetSecondRow
		$I->fillField("//span[text()='Test3 option " . msq("virtualProductCustomizableOption3") . "']/parent::div/parent::div/parent::div//tbody/tr[@data-repeat-index='1']//span[text()='SKU']/parent::label/parent::div/parent::div//div[@class='admin__field-control']/input", "sku3-2_" . msq("virtualProductCustomizableOption3")); // stepKey: fillOptionSkuForThirdDataSetSecondRow
		$I->comment("Create virtual product with customizable options dataSet4");
		$I->scrollToTopOfPage(); // stepKey: scrollToAddOptionButton
		$I->click("button[data-index='button_add']"); // stepKey: clickAddOptionButtonForFourthDataSet
		$I->waitForPageLoad(30); // stepKey: clickAddOptionButtonForFourthDataSetWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForFourthDataSetToLoad
		$I->fillField("input[name='product[options][3][title]']", "Test4 option " . msq("virtualProductCustomizableOption4")); // stepKey: fillOptionTitleForFourthDataSet
		$I->click("//table[@data-index='options']//tr[4]//div[@data-index='type']//div[contains(@class, 'action-select-wrap')]"); // stepKey: selectOptionTypeDropDownForFourthSetOfData
		$I->waitForPageLoad(30); // stepKey: selectOptionTypeDropDownForFourthSetOfDataWaitForPageLoad
		$I->click("//table[@data-index='options']//tr[4]//div[@data-index='type']//*[contains(@class, 'action-menu-item')]//*[contains(., 'Drop-down')]"); // stepKey: selectOptionFieldFromDropDownForFourthDataSet
		$I->waitForPageLoad(30); // stepKey: selectOptionFieldFromDropDownForFourthDataSetWaitForPageLoad
		$I->checkOption("input[name='product[options][3][is_require]']"); // stepKey: checkRequiredCheckBoxForFourthDataSet
		$I->click("//*[@data-index='custom_options']//*[@data-index='options']/tbody/tr[last()]//*[@data-action='add_new_row']"); // stepKey: clickAddOptionButtonForFourthDataSetToAddFirstRow
		$I->waitForPageLoad(30); // stepKey: clickAddOptionButtonForFourthDataSetToAddFirstRowWaitForPageLoad
		$I->fillField("//span[text()='Test4 option " . msq("virtualProductCustomizableOption4") . "']/parent::div/parent::div/parent::div//tbody/tr[@data-repeat-index='0']//span[text()='Title']/parent::label/parent::div/parent::div//div[@class='admin__field-control']/input", "Test4-1 " . msq("virtualProductCustomizableOption4")); // stepKey: fillOptionTitleForFourthDataSetFirstRow
		$I->fillField("//span[text()='Test4 option " . msq("virtualProductCustomizableOption4") . "']/parent::div/parent::div/parent::div//tbody/tr[@data-repeat-index='0']//span[text()='Price']/parent::label/parent::div//div[@class='admin__control-addon']/input", "10.01"); // stepKey: fillOptionPriceForFourthDataSetFirstRow
		$I->selectOption("//span[text()='Test4 option " . msq("virtualProductCustomizableOption4") . "']/parent::div/parent::div/parent::div//tbody//tr[@data-repeat-index='0']//span[text()='Price Type']/parent::label/parent::div/parent::div//select", "Percent"); // stepKey: selectOptionPriceTypeForFourthDataSetFirstRow
		$I->fillField("//span[text()='Test4 option " . msq("virtualProductCustomizableOption4") . "']/parent::div/parent::div/parent::div//tbody/tr[@data-repeat-index='0']//span[text()='SKU']/parent::label/parent::div/parent::div//div[@class='admin__field-control']/input", "sku4-1_" . msq("virtualProductCustomizableOption4")); // stepKey: fillOptionSkuForFourthDataSetFirstRow
		$I->click("//*[@data-index='custom_options']//*[@data-index='options']/tbody/tr[last()]//*[@data-action='add_new_row']"); // stepKey: clickAddOptionButtonForFourthDataSetToAddSecondRow
		$I->waitForPageLoad(30); // stepKey: clickAddOptionButtonForFourthDataSetToAddSecondRowWaitForPageLoad
		$I->fillField("//span[text()='Test4 option " . msq("virtualProductCustomizableOption4") . "']/parent::div/parent::div/parent::div//tbody/tr[@data-repeat-index='1']//span[text()='Title']/parent::label/parent::div/parent::div//div[@class='admin__field-control']/input", "Test4-2 " . msq("virtualProductCustomizableOption4")); // stepKey: fillOptionTitleForFourthDataSetSecondRow
		$I->fillField("//span[text()='Test4 option " . msq("virtualProductCustomizableOption4") . "']/parent::div/parent::div/parent::div//tbody/tr[@data-repeat-index='1']//span[text()='Price']/parent::label/parent::div//div[@class='admin__control-addon']/input", "20.02"); // stepKey: fillOptionPriceForFourthDataSetSecondRow
		$I->selectOption("//span[text()='Test4 option " . msq("virtualProductCustomizableOption4") . "']/parent::div/parent::div/parent::div//tbody//tr[@data-repeat-index='1']//span[text()='Price Type']/parent::label/parent::div/parent::div//select", "Fixed"); // stepKey: selectOptionPriceTypeForFourthDataSetSecondRow
		$I->fillField("//span[text()='Test4 option " . msq("virtualProductCustomizableOption4") . "']/parent::div/parent::div/parent::div//tbody/tr[@data-repeat-index='1']//span[text()='SKU']/parent::label/parent::div/parent::div//div[@class='admin__field-control']/input", "sku4-2_" . msq("virtualProductCustomizableOption4")); // stepKey: fillOptionSkuForFourthDataSetSecondRow
		$I->scrollToTopOfPage(); // stepKey: scrollToTopOfAdminProductFormSection
		$I->comment("Entering Action Group [clickSaveButton] AdminProductFormSaveButtonClickActionGroup");
		$I->click("#save-button"); // stepKey: clickSaveButtonClickSaveButton
		$I->waitForPageLoad(30); // stepKey: clickSaveButtonClickSaveButtonWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForProductSavedClickSaveButton
		$I->comment("Exiting Action Group [clickSaveButton] AdminProductFormSaveButtonClickActionGroup");
		$I->comment("Verify we see success message");
		$I->see("You saved the product.", "#messages"); // stepKey: seeAssertVirtualProductSuccessMessage
		$I->comment("Adding the comment to replace CliIndexerReindexActionGroup action group ('indexer:reindex' commands) for preserving Backward Compatibility");
		$I->comment("Adding the comment to replace CliCacheFlushActionGroup action group ('cache:flush' command) for preserving Backward Compatibility");
		$I->comment("Verify customer see created virtual product with custom options suite and import options(from above step) on storefront page and is searchable by sku");
		$I->amOnPage("/virtual-product" . msq("virtualProductCustomImportOptions") . ".html"); // stepKey: goToProductPage
		$I->waitForPageLoad(30); // stepKey: waitForStoreFrontProductPageLoad
		$I->comment("Entering Action Group [fillVirtualProductName] StorefrontCheckQuickSearchStringActionGroup");
		$I->fillField("#search", "virtual_sku" . msq("virtualProductCustomImportOptions")); // stepKey: fillInputFillVirtualProductName
		$I->submitForm("#search", []); // stepKey: submitQuickSearchFillVirtualProductName
		$I->seeInCurrentUrl("/catalogsearch/result/"); // stepKey: checkUrlFillVirtualProductName
		$I->dontSeeInCurrentUrl("form_key="); // stepKey: checkUrlFormKeyFillVirtualProductName
		$I->seeInTitle("Search results for: 'virtual_sku" . msq("virtualProductCustomImportOptions") . "'"); // stepKey: assertQuickSearchTitleFillVirtualProductName
		$I->see("Search results for: 'virtual_sku" . msq("virtualProductCustomImportOptions") . "'", ".page-title span"); // stepKey: assertQuickSearchNameFillVirtualProductName
		$I->comment("Exiting Action Group [fillVirtualProductName] StorefrontCheckQuickSearchStringActionGroup");
		$I->comment("Comment is added to preserve the step key for backward compatibility");
		$I->comment("Comment is added to preserve the step key for backward compatibility");
		$I->comment("Comment is added to preserve the step key for backward compatibility");
		$I->comment("Entering Action Group [seeVirtualProductName] StorefrontAssertProductNameOnProductMainPageActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForTheProductPageToLoadSeeVirtualProductName
		$I->see("VirtualProduct" . msq("virtualProductCustomImportOptions"), ".product-item-name"); // stepKey: seeProductNameSeeVirtualProductName
		$I->comment("Exiting Action Group [seeVirtualProductName] StorefrontAssertProductNameOnProductMainPageActionGroup");
		$I->click("a[class='product-item-link']"); // stepKey: openSearchedProduct
		$I->waitForPageLoad(30); // stepKey: openSearchedProductWaitForPageLoad
		$I->comment("Verify we see created virtual product with custom options suite and import options on the storefront page");
		$I->see("VirtualProduct" . msq("virtualProductCustomImportOptions"), ".base"); // stepKey: seeVirtualProductNameOnStoreFrontPage
		$I->comment("Entering Action Group [seeVirtualProductSku] StorefrontAssertProductSkuOnProductPageActionGroup");
		$I->see("virtual_sku" . msq("virtualProductCustomImportOptions"), ".product.attribute.sku>.value"); // stepKey: seeProductSkuSeeVirtualProductSku
		$I->comment("Exiting Action Group [seeVirtualProductSku] StorefrontAssertProductSkuOnProductPageActionGroup");
		$productStockAvailableStatus = $I->grabTextFrom(".stock[title=Availability]>span"); // stepKey: productStockAvailableStatus
		$I->assertEquals("IN STOCK", $productStockAvailableStatus); // stepKey: assertStockAvailableOnProductPage
		$productPriceAmount = $I->grabTextFrom("div.price-box.price-final_price"); // stepKey: productPriceAmount
		$I->assertEquals("$9,000.00", $productPriceAmount); // stepKey: assertOldPriceTextOnProductPage
		$I->comment("Verify we see customizable options are Required");
		$I->seeElement("//div[contains(.,'Test1 option " . msq("virtualProductCustomizableOption1") . "') and contains(@class, 'required') and .//input[@aria-required='true']]"); // stepKey: verifyFirstCustomOptionIsRequired
		$I->seeElement("//div[contains(.,'Test2 option " . msq("virtualProductCustomizableOption2") . "') and contains(@class, 'required') and .//input[@aria-required='true']]"); // stepKey: verifySecondCustomOptionIsRequired
		$I->seeElement("//div[contains(.,'Test3 option " . msq("virtualProductCustomizableOption3") . "') and contains(@class, 'required') and .//select[@aria-required='true']]"); // stepKey: verifyThirdCustomOptionIsRequired
		$I->seeElement("//div[contains(.,'Test4 option " . msq("virtualProductCustomizableOption4") . "') and contains(@class, 'required') and .//select[@aria-required='true']]"); // stepKey: verifyFourthCustomOptionIsRequired
		$I->comment("Verify we see customizable option titles and prices");
		$allCustomOptionLabels = $I->grabMultiple("#product-options-wrapper label"); // stepKey: allCustomOptionLabels
		$I->assertEquals(["Test1 option " . msq("virtualProductCustomizableOption1") . " + $120.03", "Test2 option " . msq("virtualProductCustomizableOption2") . " + $120.03", "Test3 option " . msq("virtualProductCustomizableOption3"), "Test4 option " . msq("virtualProductCustomizableOption4")], $allCustomOptionLabels); // stepKey: verifyLabels
		$fourthOptionId = $I->grabAttributeFrom("//label[contains(., 'Test4 option " . msq("virtualProductCustomizableOption4") . "')]", "for"); // stepKey: fourthOptionId
		$grabFourthOptions = $I->grabMultiple("#{$fourthOptionId} option"); // stepKey: grabFourthOptions
		$I->assertEquals(['-- Please Select --', "Test4-1 " . msq("virtualProductCustomizableOption4") . " +$900.90", "Test4-2 " . msq("virtualProductCustomizableOption4") . " +$20.02"], $grabFourthOptions); // stepKey: assertFourthSelectOptions
	}
}
