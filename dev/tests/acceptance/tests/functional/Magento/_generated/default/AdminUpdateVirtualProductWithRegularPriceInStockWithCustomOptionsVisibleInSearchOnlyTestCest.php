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
 * @Title("MC-6641: Update Virtual Product with Regular Price (In Stock) with Custom Options Visible in Search Only")
 * @Description("Test log in to Update Virtual Product and Update Virtual Product with Regular Price (In Stock) with Custom Options Visible in Search Only<h3>Test files</h3>app/code/Magento/Catalog/Test/Mftf/Test/AdminUpdateVirtualProductWithRegularPriceInStockWithCustomOptionsVisibleInSearchOnlyTest.xml<br>")
 * @TestCaseId("MC-6641")
 * @group catalog
 * @group mtf_migrated
 */
class AdminUpdateVirtualProductWithRegularPriceInStockWithCustomOptionsVisibleInSearchOnlyTestCest
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
		$I->comment("Entering Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin
		$I->comment("Exiting Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->createEntity("initialCategoryEntity", "hook", "SimpleSubCategory", [], []); // stepKey: initialCategoryEntity
		$I->createEntity("initialVirtualProduct", "hook", "defaultVirtualProduct", ["initialCategoryEntity"], []); // stepKey: initialVirtualProduct
		$I->createEntity("categoryEntity", "hook", "SimpleSubCategory", [], []); // stepKey: categoryEntity
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->deleteEntity("initialCategoryEntity", "hook"); // stepKey: deleteSimpleSubCategory
		$I->deleteEntity("categoryEntity", "hook"); // stepKey: deleteSimpleSubCategory2
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
	 * @Stories({"Update Virtual Product"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Features({"Catalog"})
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminUpdateVirtualProductWithRegularPriceInStockWithCustomOptionsVisibleInSearchOnlyTest(AcceptanceTester $I)
	{
		$I->comment("Search default virtual product in the grid page");
		$I->comment("Entering Action Group [openProductCatalogPage1] AdminProductCatalogPageOpenActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/"); // stepKey: openProductCatalogPageOpenProductCatalogPage1
		$I->waitForPageLoad(30); // stepKey: waitForProductCatalogPageLoadOpenProductCatalogPage1
		$I->comment("Exiting Action Group [openProductCatalogPage1] AdminProductCatalogPageOpenActionGroup");
		$I->comment("Entering Action Group [searchProductGrid] SearchProductGridByKeywordActionGroup");
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersInitialSearchProductGrid
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersInitialSearchProductGridWaitForPageLoad
		$I->fillField("input#fulltext", $I->retrieveEntityField('initialVirtualProduct', 'name', 'test')); // stepKey: fillKeywordSearchFieldSearchProductGrid
		$I->click(".data-grid-search-control-wrap button.action-submit"); // stepKey: clickKeywordSearchSearchProductGrid
		$I->waitForPageLoad(30); // stepKey: clickKeywordSearchSearchProductGridWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForProductSearchSearchProductGrid
		$I->comment("Exiting Action Group [searchProductGrid] SearchProductGridByKeywordActionGroup");
		$I->click(".data-row:nth-of-type(1)"); // stepKey: clickFirstRowToVerifyCreatedVirtualProduct
		$I->waitForPageLoad(30); // stepKey: clickFirstRowToVerifyCreatedVirtualProductWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitUntilProductIsOpened
		$I->comment("Update virtual product with regular price(in stock)");
		$I->fillField(".admin__field[data-index=name] input", "VirtualProduct" . msq("updateVirtualProductRegularPriceInStock")); // stepKey: fillProductName
		$I->fillField(".admin__field[data-index=sku] input", "virtual_sku" . msq("updateVirtualProductRegularPriceInStock")); // stepKey: fillProductSku
		$I->fillField(".admin__field[data-index=price] input", "120.00"); // stepKey: fillProductPrice
		$I->selectOption("//*[@name='product[tax_class_id]']", "None"); // stepKey: selectProductTaxClass
		$I->fillField(".admin__field[data-index=qty] input", "999"); // stepKey: fillProductQuantity
		$I->selectOption("[data-index='product-details'] select[name='product[quantity_and_stock_status][is_in_stock]']", "In Stock"); // stepKey: selectStockStatusInStock
		$I->click("div[data-index='category_ids']"); // stepKey: clickCategoriesDropDown
		$I->waitForPageLoad(30); // stepKey: clickCategoriesDropDownWaitForPageLoad
		$I->fillField("//*[@data-index='category_ids']//input[contains(@class, 'multiselect-search')]", $I->retrieveEntityField('initialCategoryEntity', 'name', 'test')); // stepKey: fillSearchForInitialCategory
		$I->waitForPageLoad(30); // stepKey: fillSearchForInitialCategoryWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCategory1
		$I->click("//*[@data-index='category_ids']//label[contains(., '" . $I->retrieveEntityField('initialCategoryEntity', 'name', 'test') . "')]"); // stepKey: unselectInitialCategory
		$I->waitForPageLoad(30); // stepKey: unselectInitialCategoryWaitForPageLoad
		$I->fillField("//*[@data-index='category_ids']//input[contains(@class, 'multiselect-search')]", $I->retrieveEntityField('categoryEntity', 'name', 'test')); // stepKey: fillSearchCategory
		$I->waitForPageLoad(30); // stepKey: fillSearchCategoryWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCategory2
		$I->click("//*[@data-index='category_ids']//label[contains(., '" . $I->retrieveEntityField('categoryEntity', 'name', 'test') . "')]"); // stepKey: clickOnCategory
		$I->waitForPageLoad(30); // stepKey: clickOnCategoryWaitForPageLoad
		$I->comment("Entering Action Group [clickOnDoneAdvancedCategorySelect] AdminSubmitCategoriesPopupActionGroup");
		$I->click("//*[@data-index='category_ids']//button[@data-action='close-advanced-select']"); // stepKey: clickOnDoneButtonClickOnDoneAdvancedCategorySelect
		$I->waitForPageLoad(30); // stepKey: clickOnDoneButtonClickOnDoneAdvancedCategorySelectWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCategoryApplyClickOnDoneAdvancedCategorySelect
		$I->comment("Exiting Action Group [clickOnDoneAdvancedCategorySelect] AdminSubmitCategoriesPopupActionGroup");
		$I->selectOption("//select[@name='product[visibility]']", "Search"); // stepKey: selectVisibility
		$I->click("div[data-index='search-engine-optimization']"); // stepKey: clickAdminProductSEOSection
		$I->waitForPageLoad(30); // stepKey: clickAdminProductSEOSectionWaitForPageLoad
		$I->fillField("input[name='product[url_key]']", "virtual-product" . msq("updateVirtualProductRegularPriceInStock")); // stepKey: fillUrlKey
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
		$I->see("You saved the product.", "#messages"); // stepKey: seeAssertVirtualProductSaveSuccessMessage
		$I->comment("Search updated virtual product(from above step) in the grid page");
		$I->comment("Entering Action Group [openProductCatalogPageToSearchUpdatedVirtualProduct] AdminProductCatalogPageOpenActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/"); // stepKey: openProductCatalogPageOpenProductCatalogPageToSearchUpdatedVirtualProduct
		$I->waitForPageLoad(30); // stepKey: waitForProductCatalogPageLoadOpenProductCatalogPageToSearchUpdatedVirtualProduct
		$I->comment("Exiting Action Group [openProductCatalogPageToSearchUpdatedVirtualProduct] AdminProductCatalogPageOpenActionGroup");
		$I->conditionalClick(".admin__data-grid-header .admin__data-grid-filters-current._show .action-clear", ".admin__data-grid-header .admin__data-grid-filters-current._show .action-clear", true); // stepKey: clickClearAll
		$I->waitForPageLoad(30); // stepKey: clickClearAllWaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: clickFiltersButton
		$I->fillField("input.admin__control-text[name='name']", "VirtualProduct" . msq("updateVirtualProductRegularPriceInStock")); // stepKey: fillVirtualProductNameInNameFilter
		$I->fillField("input.admin__control-text[name='sku']", "virtual_sku" . msq("updateVirtualProductRegularPriceInStock")); // stepKey: fillVirtualProductSku
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersButton
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersButtonWaitForPageLoad
		$I->click(".data-row:nth-of-type(1)"); // stepKey: clickFirstRowToVerifyUpdatedVirtualProductVisibleInGrid
		$I->waitForPageLoad(30); // stepKey: clickFirstRowToVerifyUpdatedVirtualProductVisibleInGridWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitUntilVirtualProductPageIsOpened
		$I->comment("Verify we customer see updated virtual product in the product form page");
		$I->seeInField(".admin__field[data-index=name] input", "VirtualProduct" . msq("updateVirtualProductRegularPriceInStock")); // stepKey: seeProductName
		$I->seeInField(".admin__field[data-index=sku] input", "virtual_sku" . msq("updateVirtualProductRegularPriceInStock")); // stepKey: seeProductSku
		$I->seeInField(".admin__field[data-index=price] input", "120.00"); // stepKey: seeProductPrice
		$I->seeInField("//*[@name='product[tax_class_id]']", "None"); // stepKey: seeProductTaxClass
		$I->seeInField(".admin__field[data-index=qty] input", "999"); // stepKey: seeProductQuantity
		$I->seeInField("select[name='product[quantity_and_stock_status][is_in_stock]']", "In Stock"); // stepKey: seeProductStockStatus
		$I->waitForPageLoad(30); // stepKey: seeProductStockStatusWaitForPageLoad
		$I->click("div[data-index='category_ids']"); // stepKey: clickCategoriesDropDownToVerify
		$I->waitForPageLoad(30); // stepKey: clickCategoriesDropDownToVerifyWaitForPageLoad
		$selectedCategories = $I->grabMultiple("//*[@data-index='container_category_ids']//*[contains(@class, '_selected')]"); // stepKey: selectedCategories
		$I->assertEquals([$I->retrieveEntityField('categoryEntity', 'name', 'test')], $selectedCategories); // stepKey: assertSelectedCategories
		$I->comment("Entering Action Group [clickOnDoneOnCategorySelect] AdminSubmitCategoriesPopupActionGroup");
		$I->click("//*[@data-index='category_ids']//button[@data-action='close-advanced-select']"); // stepKey: clickOnDoneButtonClickOnDoneOnCategorySelect
		$I->waitForPageLoad(30); // stepKey: clickOnDoneButtonClickOnDoneOnCategorySelectWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCategoryApplyClickOnDoneOnCategorySelect
		$I->comment("Exiting Action Group [clickOnDoneOnCategorySelect] AdminSubmitCategoriesPopupActionGroup");
		$I->seeInField("//select[@name='product[visibility]']", "Search"); // stepKey: seeVisibility
		$I->scrollTo("div[data-index='search-engine-optimization']", 0, -80); // stepKey: scrollToAdminProductSEOSection1
		$I->waitForPageLoad(30); // stepKey: scrollToAdminProductSEOSection1WaitForPageLoad
		$I->click("div[data-index='search-engine-optimization']"); // stepKey: clickAdminProductSEOSection1
		$I->waitForPageLoad(30); // stepKey: clickAdminProductSEOSection1WaitForPageLoad
		$I->seeInField("input[name='product[url_key]']", "virtual-product" . msq("updateVirtualProductRegularPriceInStock")); // stepKey: seeUrlKey
		$I->click("//span[text()='Customizable Options']/parent::strong/parent::*[@data-state-collapsible='closed']"); // stepKey: clickAdminProductCustomizableOptionToSeeValues
		$I->waitForPageLoad(30); // stepKey: clickAdminProductCustomizableOptionToSeeValuesWaitForPageLoad
		$I->comment("Create virtual product with customizable options dataSet1");
		$I->click("button[data-index='button_add']"); // stepKey: clickAddOptionButton1
		$I->waitForPageLoad(30); // stepKey: clickAddOptionButton1WaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForFirstOptionToLoad
		$I->seeInField("input[name='product[options][0][title]']", "Test1 option " . msq("virtualProductCustomizableOption1")); // stepKey: seeOptionTitleForFirstDataSet
		$I->click("//table[@data-index='options']//tr[1]//div[@data-index='type']//div[contains(@class, 'action-select-wrap')]"); // stepKey: selectOptionTypeDropDownFirstDataSet1
		$I->waitForPageLoad(30); // stepKey: selectOptionTypeDropDownFirstDataSet1WaitForPageLoad
		$I->click("//table[@data-index='options']//tr[1]//div[@data-index='type']//*[contains(@class, 'action-menu-item')]//*[contains(., 'Field')]"); // stepKey: selectOptionFieldFromDropDownForFirstDataSet1
		$I->waitForPageLoad(30); // stepKey: selectOptionFieldFromDropDownForFirstDataSet1WaitForPageLoad
		$I->checkOption("input[name='product[options][0][is_require]']"); // stepKey: checkRequiredCheckBoxForFirstDataSet1
		$I->seeInField("//*[@data-index='custom_options']//*[@data-index='options']/tbody/tr//*[@name='product[options][0][price]']", "120.03"); // stepKey: seeOptionPriceForFirstDataSet
		$I->seeOptionIsSelected("//*[@data-index='custom_options']//*[@data-index='options']/tbody/tr//*[@name='product[options][0][price_type]']", "Fixed"); // stepKey: selectOptionPriceTypeForFirstDataSet1
		$I->seeInField("//*[@data-index='custom_options']//*[@data-index='options']/tbody/tr//*[@name='product[options][0][sku]']", "sku1_" . msq("virtualProductCustomizableOption1")); // stepKey: seeOptionSkuForFirstDataSet
		$I->seeInField("input[name='product[options][0][max_characters]']", "45"); // stepKey: seeOptionMaxCharactersForFirstDataSet
		$I->comment("Create virtual product with customizable options dataSet2");
		$I->click("button[data-index='button_add']"); // stepKey: clickAddOptionButtonForSecondDataSetToSeeFields
		$I->waitForPageLoad(30); // stepKey: clickAddOptionButtonForSecondDataSetToSeeFieldsWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForTheSecondDataSetToLoad
		$I->seeInField("input[name='product[options][1][title]']", "Test2 option " . msq("virtualProductCustomizableOption2")); // stepKey: seeOptionTitleForSecondDataSet
		$I->click("//table[@data-index='options']//tr[2]//div[@data-index='type']//div[contains(@class, 'action-select-wrap')]"); // stepKey: selectOptionTypeDropDownSecondDataSet2
		$I->waitForPageLoad(30); // stepKey: selectOptionTypeDropDownSecondDataSet2WaitForPageLoad
		$I->click("//table[@data-index='options']//tr[2]//div[@data-index='type']//*[contains(@class, 'action-menu-item')]//*[contains(., 'Field')]"); // stepKey: selectOptionFieldFromDropDownForSecondDataSet2
		$I->waitForPageLoad(30); // stepKey: selectOptionFieldFromDropDownForSecondDataSet2WaitForPageLoad
		$I->checkOption("input[name='product[options][1][is_require]']"); // stepKey: checkRequiredCheckBoxForTheSecondDataSet
		$I->seeInField("//*[@data-index='custom_options']//*[@data-index='options']/tbody/tr//*[@name='product[options][1][price]']", "120.03"); // stepKey: seeOptionPriceForSecondDataSet
		$I->seeOptionIsSelected("//*[@data-index='custom_options']//*[@data-index='options']/tbody/tr//*[@name='product[options][1][price_type]']", "Fixed"); // stepKey: selectOptionPriceTypeForTheSecondDataSet
		$I->seeInField("//*[@data-index='custom_options']//*[@data-index='options']/tbody/tr//*[@name='product[options][1][sku]']", "sku2_" . msq("virtualProductCustomizableOption2")); // stepKey: seeOptionSkuForSecondDataSet
		$I->seeInField("input[name='product[options][0][max_characters]']", "45"); // stepKey: seeOptionMaxCharactersForSecondDataSet
		$I->comment("Create virtual product with customizable options dataSet3");
		$I->click("button[data-index='button_add']"); // stepKey: clickAddOptionButtonForTheThirdSetOfData
		$I->waitForPageLoad(30); // stepKey: clickAddOptionButtonForTheThirdSetOfDataWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForTheThirdSetOfDataToLoad
		$I->seeInField("input[name='product[options][2][title]']", "Test3 option " . msq("virtualProductCustomizableOption3")); // stepKey: seeOptionTitleForThirdDataSet
		$I->click("//table[@data-index='options']//tr[3]//div[@data-index='type']//div[contains(@class, 'action-select-wrap')]"); // stepKey: selectOptionTypeDropDownForTheThirdDataSet
		$I->waitForPageLoad(30); // stepKey: selectOptionTypeDropDownForTheThirdDataSetWaitForPageLoad
		$I->click("//table[@data-index='options']//tr[3]//div[@data-index='type']//*[contains(@class, 'action-menu-item')]//*[contains(., 'Drop-down')]"); // stepKey: selectOptionFieldFromDropDownForTheThirdDataSet
		$I->waitForPageLoad(30); // stepKey: selectOptionFieldFromDropDownForTheThirdDataSetWaitForPageLoad
		$I->checkOption("input[name='product[options][2][is_require]']"); // stepKey: checkRequiredCheckBoxForTheThirdDataSet
		$I->seeInField("//span[text()='Test3 option " . msq("virtualProductCustomizableOption3") . "']/parent::div/parent::div/parent::div//tbody/tr[@data-repeat-index='0']//span[text()='Title']/parent::label/parent::div/parent::div//div[@class='admin__field-control']/input", "Test3-1 " . msq("virtualProductCustomizableOption3")); // stepKey: seeOptionTitleForThirdDataSetFirstRow
		$I->seeInField("//span[text()='Test3 option " . msq("virtualProductCustomizableOption3") . "']/parent::div/parent::div/parent::div//tbody/tr[@data-repeat-index='0']//span[text()='Price']/parent::label/parent::div//div[@class='admin__control-addon']/input", "110.01"); // stepKey: seeOptionPriceForThirdDataSetFirstRow
		$I->seeOptionIsSelected("//span[text()='Test3 option " . msq("virtualProductCustomizableOption3") . "']/parent::div/parent::div/parent::div//tbody//tr[@data-repeat-index='0']//span[text()='Price Type']/parent::label/parent::div/parent::div//select", "Percent"); // stepKey: selectOptionPriceTypeForTheThirdDataSetFirstRow
		$I->seeInField("//span[text()='Test3 option " . msq("virtualProductCustomizableOption3") . "']/parent::div/parent::div/parent::div//tbody/tr[@data-repeat-index='0']//span[text()='SKU']/parent::label/parent::div/parent::div//div[@class='admin__field-control']/input", "sku3-1_" . msq("virtualProductCustomizableOption3")); // stepKey: seeOptionSkuForThirdDataSetFirstRow
		$I->seeInField("//span[text()='Test3 option " . msq("virtualProductCustomizableOption3") . "']/parent::div/parent::div/parent::div//tbody/tr[@data-repeat-index='1']//span[text()='Title']/parent::label/parent::div/parent::div//div[@class='admin__field-control']/input", "Test3-2 " . msq("virtualProductCustomizableOption3")); // stepKey: seeOptionTitleForThirdDataSetSecondRow
		$I->seeInField("//span[text()='Test3 option " . msq("virtualProductCustomizableOption3") . "']/parent::div/parent::div/parent::div//tbody/tr[@data-repeat-index='1']//span[text()='Price']/parent::label/parent::div//div[@class='admin__control-addon']/input", "210.02"); // stepKey: seeOptionPriceForThirdDataSetSecondRow
		$I->selectOption("//span[text()='Test3 option " . msq("virtualProductCustomizableOption3") . "']/parent::div/parent::div/parent::div//tbody//tr[@data-repeat-index='1']//span[text()='Price Type']/parent::label/parent::div/parent::div//select", "Fixed"); // stepKey: selectOptionPriceTypeForTheThirdDataSetSecondRow
		$I->seeInField("//span[text()='Test3 option " . msq("virtualProductCustomizableOption3") . "']/parent::div/parent::div/parent::div//tbody/tr[@data-repeat-index='1']//span[text()='SKU']/parent::label/parent::div/parent::div//div[@class='admin__field-control']/input", "sku3-2_" . msq("virtualProductCustomizableOption3")); // stepKey: seeOptionSkuForThirdDataSetSecondRow
		$I->comment("Create virtual product with customizable options dataSet4");
		$I->scrollToTopOfPage(); // stepKey: scrollToTheAddOptionButton
		$I->click("button[data-index='button_add']"); // stepKey: clickAddOptionButtonForTheFourthDataSet
		$I->waitForPageLoad(30); // stepKey: clickAddOptionButtonForTheFourthDataSetWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForTheFourthDataSetToLoad
		$I->fillField("input[name='product[options][3][title]']", "Test4 option " . msq("virtualProductCustomizableOption4")); // stepKey: fillOptionTitleForTheFourthDataSet
		$I->click("//table[@data-index='options']//tr[4]//div[@data-index='type']//div[contains(@class, 'action-select-wrap')]"); // stepKey: selectOptionTypeDropDownForTheFourthSetOfData
		$I->waitForPageLoad(30); // stepKey: selectOptionTypeDropDownForTheFourthSetOfDataWaitForPageLoad
		$I->click("//table[@data-index='options']//tr[4]//div[@data-index='type']//*[contains(@class, 'action-menu-item')]//*[contains(., 'Drop-down')]"); // stepKey: selectOptionFieldFromDropDownForTheFourthDataSet
		$I->waitForPageLoad(30); // stepKey: selectOptionFieldFromDropDownForTheFourthDataSetWaitForPageLoad
		$I->checkOption("input[name='product[options][3][is_require]']"); // stepKey: checkRequiredCheckBoxForTheFourthDataSet
		$I->seeInField("//span[text()='Test4 option " . msq("virtualProductCustomizableOption4") . "']/parent::div/parent::div/parent::div//tbody/tr[@data-repeat-index='0']//span[text()='Title']/parent::label/parent::div/parent::div//div[@class='admin__field-control']/input", "Test4-1 " . msq("virtualProductCustomizableOption4")); // stepKey: seeOptionTitleForFourthDataSetFirstRow
		$I->seeInField("//span[text()='Test4 option " . msq("virtualProductCustomizableOption4") . "']/parent::div/parent::div/parent::div//tbody/tr[@data-repeat-index='0']//span[text()='Price']/parent::label/parent::div//div[@class='admin__control-addon']/input", "10.01"); // stepKey: seeOptionPriceForFourthDataSetFirstRow
		$I->seeOptionIsSelected("//span[text()='Test4 option " . msq("virtualProductCustomizableOption4") . "']/parent::div/parent::div/parent::div//tbody//tr[@data-repeat-index='0']//span[text()='Price Type']/parent::label/parent::div/parent::div//select", "Percent"); // stepKey: selectOptionPriceTypeForTheFourthDataSetFirstRow
		$I->seeInField("//span[text()='Test4 option " . msq("virtualProductCustomizableOption4") . "']/parent::div/parent::div/parent::div//tbody/tr[@data-repeat-index='0']//span[text()='SKU']/parent::label/parent::div/parent::div//div[@class='admin__field-control']/input", "sku4-1_" . msq("virtualProductCustomizableOption4")); // stepKey: seeOptionSkuForFourthDataSetFirstRow
		$I->seeInField("//span[text()='Test4 option " . msq("virtualProductCustomizableOption4") . "']/parent::div/parent::div/parent::div//tbody/tr[@data-repeat-index='1']//span[text()='Title']/parent::label/parent::div/parent::div//div[@class='admin__field-control']/input", "Test4-2 " . msq("virtualProductCustomizableOption4")); // stepKey: seeOptionTitleForFourthDataSetSecondRow
		$I->seeInField("//span[text()='Test4 option " . msq("virtualProductCustomizableOption4") . "']/parent::div/parent::div/parent::div//tbody/tr[@data-repeat-index='1']//span[text()='Price']/parent::label/parent::div//div[@class='admin__control-addon']/input", "20.02"); // stepKey: seeOptionPriceForFourthDataSetSecondRow
		$I->selectOption("//span[text()='Test4 option " . msq("virtualProductCustomizableOption4") . "']/parent::div/parent::div/parent::div//tbody//tr[@data-repeat-index='1']//span[text()='Price Type']/parent::label/parent::div/parent::div//select", "Fixed"); // stepKey: selectOptionPriceTypeForTheFourthDataSetSecondRow
		$I->seeInField("//span[text()='Test4 option " . msq("virtualProductCustomizableOption4") . "']/parent::div/parent::div/parent::div//tbody/tr[@data-repeat-index='1']//span[text()='SKU']/parent::label/parent::div/parent::div//div[@class='admin__field-control']/input", "sku4-2_" . msq("virtualProductCustomizableOption4")); // stepKey: seeOptionSkuForFourthDataSetSecondRow
		$I->comment("Verify customer don't see updated virtual product link on category page");
		$I->amOnPage("/" . $I->retrieveEntityField('categoryEntity', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: openCategoryPage
		$I->waitForPageLoad(30); // stepKey: waitForCategoryPageLoad
		$I->dontSee("VirtualProduct" . msq("updateVirtualProductRegularPriceInStock"), "a.product-item-link"); // stepKey: dontSeeVirtualProductNameOnCategoryPage
		$I->waitForPageLoad(30); // stepKey: dontSeeVirtualProductNameOnCategoryPageWaitForPageLoad
		$I->comment("Verify customer see updated virtual product (from the above step) on the storefront page");
		$I->amOnPage("/virtual-product" . msq("updateVirtualProductRegularPriceInStock") . ".html"); // stepKey: goToProductPage
		$I->waitForPageLoad(30); // stepKey: waitForStorefrontProductPageLoad
		$I->see("VirtualProduct" . msq("updateVirtualProductRegularPriceInStock"), ".base"); // stepKey: seeVirtualProductNameOnStoreFrontPage
		$I->see("120.00", "div.price-box.price-final_price"); // stepKey: seeVirtualProductPriceOnStoreFrontPage
		$I->comment("Entering Action Group [seeVirtualProductSku] StorefrontAssertProductSkuOnProductPageActionGroup");
		$I->see("virtual_sku" . msq("updateVirtualProductRegularPriceInStock"), ".product.attribute.sku>.value"); // stepKey: seeProductSkuSeeVirtualProductSku
		$I->comment("Exiting Action Group [seeVirtualProductSku] StorefrontAssertProductSkuOnProductPageActionGroup");
		$productStockAvailableStatus = $I->grabTextFrom(".stock[title=Availability]>span"); // stepKey: productStockAvailableStatus
		$I->assertEquals("IN STOCK", $productStockAvailableStatus); // stepKey: assertStockAvailableOnProductPage
		$productPriceAmount = $I->grabTextFrom("div.price-box.price-final_price"); // stepKey: productPriceAmount
		$I->assertEquals("$120.00", $productPriceAmount); // stepKey: assertOldPriceTextOnProductPage
		$I->comment("Verify we customer see customizable options are Required");
		$I->seeElement("//div[contains(.,'Test1 option " . msq("virtualProductCustomizableOption1") . "') and contains(@class, 'required') and .//input[@aria-required='true']]"); // stepKey: verifyFirstCustomOptionIsRequired
		$I->seeElement("//div[contains(.,'Test2 option " . msq("virtualProductCustomizableOption2") . "') and contains(@class, 'required') and .//input[@aria-required='true']]"); // stepKey: verifySecondCustomOptionIsRequired
		$I->seeElement("//div[contains(.,'Test3 option " . msq("virtualProductCustomizableOption3") . "') and contains(@class, 'required') and .//select[@aria-required='true']]"); // stepKey: verifyThirdCustomOptionIsRequired
		$I->seeElement("//div[contains(.,'Test4 option " . msq("virtualProductCustomizableOption4") . "') and contains(@class, 'required') and .//select[@aria-required='true']]"); // stepKey: verifyFourthCustomOptionIsRequired
		$I->comment("Verify customer see customizable option titles and prices");
		$allCustomOptionLabels = $I->grabMultiple("#product-options-wrapper label"); // stepKey: allCustomOptionLabels
		$I->assertEquals(["Test1 option " . msq("virtualProductCustomizableOption1") . " + $120.03", "Test2 option " . msq("virtualProductCustomizableOption2") . " + $120.03", "Test3 option " . msq("virtualProductCustomizableOption3"), "Test4 option " . msq("virtualProductCustomizableOption4")], $allCustomOptionLabels); // stepKey: verifyLabels
		$fourthOptionId = $I->grabAttributeFrom("//label[contains(., 'Test4 option " . msq("virtualProductCustomizableOption4") . "')]", "for"); // stepKey: fourthOptionId
		$grabFourthOptions = $I->grabMultiple("#{$fourthOptionId} option"); // stepKey: grabFourthOptions
		$I->assertEquals(['-- Please Select --', "Test4-1 " . msq("virtualProductCustomizableOption4") . " +$12.01", "Test4-2 " . msq("virtualProductCustomizableOption4") . " +$20.02"], $grabFourthOptions); // stepKey: assertFourthSelectOptions
	}
}
