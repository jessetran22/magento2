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
 * @Title("MC-222: Admin should be able to set/edit all the basic product attributes when creating/editing a bundle product")
 * @Description("Admin should be able to set/edit all the basic product attributes when creating/editing a bundle product<h3>Test files</h3>app/code/Magento/Bundle/Test/Mftf/Test/AdminBasicBundleProductAttributesTest.xml<br>")
 * @TestCaseId("MC-222")
 * @group Bundle
 */
class AdminBasicBundleProductAttributesTestCest
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
        $this->helperContainer->create("\Magento\Catalog\Test\Mftf\Helper\LocalFileAssertions");
        $this->helperContainer->create("\Magento\Backend\Test\Mftf\Helper\CurlHelpers");
        $this->helperContainer->create("Magento\Rule\Test\Mftf\Helper\RuleHelper");
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
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [amOnLogoutPage] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageAmOnLogoutPage
		$I->comment("Exiting Action Group [amOnLogoutPage] AdminLogoutActionGroup");
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
	 * @Features({"Bundle"})
	 * @Stories({"Create/Edit bundle product in Admin"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminBasicBundleProductAttributesTest(AcceptanceTester $I)
	{
		$I->comment("Create attribute set");
		$I->comment("Entering Action Group [createDefaultAttributeSet] CreateDefaultAttributeSetActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product_set/"); // stepKey: goToAttributeSetsCreateDefaultAttributeSet
		$I->waitForPageLoad(30); // stepKey: wait1CreateDefaultAttributeSet
		$I->click("button.add-set"); // stepKey: clickAddAttributeSetCreateDefaultAttributeSet
		$I->waitForPageLoad(30); // stepKey: clickAddAttributeSetCreateDefaultAttributeSetWaitForPageLoad
		$I->fillField("#attribute_set_name", "attribute" . msq("ProductAttributeFrontendLabel")); // stepKey: fillNameCreateDefaultAttributeSet
		$I->click("button.save-attribute-set"); // stepKey: clickSave1CreateDefaultAttributeSet
		$I->waitForPageLoad(30); // stepKey: clickSave1CreateDefaultAttributeSetWaitForPageLoad
		$I->comment("Exiting Action Group [createDefaultAttributeSet] CreateDefaultAttributeSetActionGroup");
		$I->comment("Go to product creation page");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/new/set/4/type/bundle/"); // stepKey: goToBundleProductCreationPage
		$I->waitForPageLoad(30); // stepKey: waitForBundleProductCreationPage
		$I->comment("Enable/Disable Toggle");
		$I->checkOption("//*[@id='container']//input[@name='product[status]']/.."); // stepKey: clickOnEnableDisableToggle
		$I->waitForPageLoad(30); // stepKey: clickOnEnableDisableToggleWaitForPageLoad
		$I->comment("Fill out product attributes");
		$I->comment("Entering Action Group [fillOutAllAttributes] SetBundleProductAttributes");
		$I->comment("Pre-Reqs:
        1) Go to bundle product creation page
        2) Will not Enable/Disable");
		$I->comment("Apply Attribute Set");
		$I->click("div[data-index='attribute_set_id'] .admin__field-control"); // stepKey: startEditAttrSetFillOutAllAttributes
		$I->fillField("div[data-index='attribute_set_id'] .admin__field-control input", "attribute" . msq("ProductAttributeFrontendLabel")); // stepKey: searchForAttrSetFillOutAllAttributes
		$I->waitForPageLoad(30); // stepKey: searchForAttrSetFillOutAllAttributesWaitForPageLoad
		$I->click("div[data-index='attribute_set_id'] .action-menu-item._last"); // stepKey: selectAttrSetFillOutAllAttributes
		$I->waitForPageLoad(30); // stepKey: selectAttrSetFillOutAllAttributesWaitForPageLoad
		$I->comment("Product name and SKU");
		$I->fillField("//*[@name='product[name]']", "BundleProduct" . msq("BundleProduct")); // stepKey: fillProductNameFillOutAllAttributes
		$I->fillField("//*[@name='product[sku]']", "bundleproduct" . msq("BundleProduct")); // stepKey: fillProductSkuFillOutAllAttributes
		$I->click("//*[@name='product[name]']"); // stepKey: clickUnselectFieldFillOutAllAttributes
		$I->comment("Dynamic SKU Toggle");
		$I->checkOption("div[data-index='sku_type'] .admin__actions-switch-label"); // stepKey: clickOnToggleFillOutAllAttributes
		$I->waitForPageLoad(30); // stepKey: clickOnToggleFillOutAllAttributesWaitForPageLoad
		$I->click("//*[@name='product[name]']"); // stepKey: clickUnselectFieldAgainFillOutAllAttributes
		$I->comment("Dynamic Price Toggle");
		$I->checkOption("//div[@data-index='price_type']//div[@data-role='switcher']"); // stepKey: clickOnDynamicPriceToggleFillOutAllAttributes
		$I->comment("Tax Class");
		$I->selectOption("//select[@name='product[tax_class_id]']", "Taxable Goods"); // stepKey: taxClassDropDownFillOutAllAttributes
		$I->waitForPageLoad(30); // stepKey: taxClassDropDownFillOutAllAttributesWaitForPageLoad
		$I->comment("Fill out price");
		$I->fillField("//div[@data-index='price']//input", "10"); // stepKey: fillOutPriceFillOutAllAttributes
		$I->comment("Stock status");
		$I->selectOption("//select[@name='product[quantity_and_stock_status][is_in_stock]']", "In Stock"); // stepKey: stockStatusFillOutAllAttributes
		$I->comment("Dynamic weight");
		$I->checkOption("//div[@data-index='weight_type']//div[@data-role='switcher']"); // stepKey: dynamicWeightFillOutAllAttributes
		$I->waitForPageLoad(30); // stepKey: dynamicWeightFillOutAllAttributesWaitForPageLoad
		$I->comment("Weight");
		$I->fillField("//div[@data-index='weight']//input", "10"); // stepKey: fillInFillOutAllAttributes
		$I->comment("Visibility");
		$I->selectOption("//select[@name='product[visibility]']", "Catalog, Search"); // stepKey: openVisibilityFillOutAllAttributes
		$I->comment("Categories");
		$I->click("//div[@data-index='category_ids']//div[@class='admin__field-control']"); // stepKey: clickOnCategoriesDropDownFillOutAllAttributes
		$I->waitForPageLoad(30); // stepKey: clickOnCategoriesDropDownFillOutAllAttributesWaitForPageLoad
		$I->click("//div[@data-index='category_ids']//span[contains(text(), 'Default Category')]"); // stepKey: selectDefaultCategoryFillOutAllAttributes
		$I->click(".admin__action-multiselect-actions-wrap [type='button'] span"); // stepKey: clickOnCategoriesDoneToCloseOptionsFillOutAllAttributes
		$I->waitForPageLoad(30); // stepKey: clickOnCategoriesDoneToCloseOptionsFillOutAllAttributesWaitForPageLoad
		$I->comment("New from - to");
		$I->fillField("//div[@data-index='news_from_date']//input", "10/10/2018"); // stepKey: fillInFirstDateFillOutAllAttributes
		$I->fillField("//div[@data-index='news_to_date']//input", "10/10/2018"); // stepKey: fillInSecondDateFillOutAllAttributes
		$I->comment("Country of manufacture");
		$I->selectOption("//select[@name='product[country_of_manufacture]']", "Italy"); // stepKey: countryOfManufactureDropDownFillOutAllAttributes
		$I->comment("Save the product");
		$I->click("#save-button"); // stepKey: clickSaveButtonFillOutAllAttributes
		$I->waitForPageLoad(30); // stepKey: clickSaveButtonFillOutAllAttributesWaitForPageLoad
		$I->seeElement(".message-success"); // stepKey: messageYouSavedTheProductIsShownFillOutAllAttributes
		$I->comment("Exiting Action Group [fillOutAllAttributes] SetBundleProductAttributes");
		$I->comment("Verify form was filled out correctly");
		$I->comment("Enable/Disable Toggle check");
		$I->dontSeeCheckboxIsChecked("//*[@id='container']//input[@name='product[status]']/.."); // stepKey: seeToggleIsOff
		$I->waitForPageLoad(30); // stepKey: seeToggleIsOffWaitForPageLoad
		$I->comment("Apply Attribute Set");
		$I->seeOptionIsSelected("div[data-index='attribute_set_id'] .admin__field-control", "attribute" . msq("ProductAttributeFrontendLabel")); // stepKey: seeAttributeSet
		$I->comment("Product name and SKU");
		$I->seeInField("//*[@name='product[name]']", "BundleProduct" . msq("BundleProduct")); // stepKey: seeProductName
		$I->seeInField("//*[@name='product[sku]']", "bundleproduct" . msq("BundleProduct")); // stepKey: seeProductSku
		$I->comment("Dynamic SKU Toggle");
		$I->dontSeeCheckboxIsChecked("div[data-index='sku_type'] .admin__actions-switch-label"); // stepKey: seeDynamicSkuToggleOff
		$I->waitForPageLoad(30); // stepKey: seeDynamicSkuToggleOffWaitForPageLoad
		$I->comment("Dynamic Price Toggle");
		$I->dontSeeCheckboxIsChecked("//div[@data-index='price_type']//div[@data-role='switcher']"); // stepKey: seeDynamicPriceToggleOff
		$I->comment("Tax Class");
		$I->seeOptionIsSelected("//select[@name='product[tax_class_id]']", "Taxable Goods"); // stepKey: seeCorrectTaxClass
		$I->waitForPageLoad(30); // stepKey: seeCorrectTaxClassWaitForPageLoad
		$I->comment("Fill out price");
		$I->seeInField("//div[@data-index='price']//input", "10.00"); // stepKey: seePrice
		$I->comment("Stock status");
		$I->seeOptionIsSelected("//select[@name='product[quantity_and_stock_status][is_in_stock]']", "In Stock"); // stepKey: seeStockStatus
		$I->comment("Dynamic weight");
		$I->dontSeeCheckboxIsChecked("//div[@data-index='weight_type']//div[@data-role='switcher']"); // stepKey: seeDynamicWeightOff
		$I->waitForPageLoad(30); // stepKey: seeDynamicWeightOffWaitForPageLoad
		$I->comment("Weight");
		$I->seeInField("//div[@data-index='weight']//input", "10"); // stepKey: seeWeight
		$I->comment("Visibilty");
		$I->seeOptionIsSelected("//select[@name='product[visibility]']", "Catalog"); // stepKey: seeVisibility
		$I->comment("Categories");
		$I->seeElement("//div[@data-index='category_ids']//span[contains(text(), 'Default Category')]"); // stepKey: seeDefaultCategory
		$I->comment("New from - to");
		$I->seeInField("//div[@data-index='news_from_date']//input", "10/10/2018"); // stepKey: seeFirstDate
		$I->seeInField("//div[@data-index='news_to_date']//input", "10/10/2018"); // stepKey: seeSecondDate
		$I->comment("Country of manufacture");
		$I->seeOptionIsSelected("//select[@name='product[country_of_manufacture]']", "Italy"); // stepKey: seeCountryOfManufacture
		$I->comment("Create second attribute set for edit");
		$I->comment("Entering Action Group [createSecondAttributeSet] CreateDefaultAttributeSetActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product_set/"); // stepKey: goToAttributeSetsCreateSecondAttributeSet
		$I->waitForPageLoad(30); // stepKey: wait1CreateSecondAttributeSet
		$I->click("button.add-set"); // stepKey: clickAddAttributeSetCreateSecondAttributeSet
		$I->waitForPageLoad(30); // stepKey: clickAddAttributeSetCreateSecondAttributeSetWaitForPageLoad
		$I->fillField("#attribute_set_name", "attributeTwo" . msq("ProductAttributeFrontendLabelTwo")); // stepKey: fillNameCreateSecondAttributeSet
		$I->click("button.save-attribute-set"); // stepKey: clickSave1CreateSecondAttributeSet
		$I->waitForPageLoad(30); // stepKey: clickSave1CreateSecondAttributeSetWaitForPageLoad
		$I->comment("Exiting Action Group [createSecondAttributeSet] CreateDefaultAttributeSetActionGroup");
		$I->comment("Filter catalog");
		$I->comment("Entering Action Group [goToCatalogProductPage] AdminOpenCatalogProductPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/"); // stepKey: openCatalogProductPageGoToCatalogProductPage
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadGoToCatalogProductPage
		$I->comment("Exiting Action Group [goToCatalogProductPage] AdminOpenCatalogProductPageActionGroup");
		$I->comment("Entering Action Group [filterBundleProductOptionsDownToName] FilterProductGridByNameActionGroup");
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersFilterBundleProductOptionsDownToName
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersFilterBundleProductOptionsDownToNameWaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFiltersFilterBundleProductOptionsDownToName
		$I->fillField("input.admin__control-text[name='name']", "BundleProduct" . msq("BundleProduct")); // stepKey: fillProductNameFilterFilterBundleProductOptionsDownToName
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersFilterBundleProductOptionsDownToName
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersFilterBundleProductOptionsDownToNameWaitForPageLoad
		$I->waitForElementNotVisible(".admin__data-grid-loading-mask[data-component*='product_listing']", 30); // stepKey: waitForFilteredGridLoadFilterBundleProductOptionsDownToName
		$I->comment("Exiting Action Group [filterBundleProductOptionsDownToName] FilterProductGridByNameActionGroup");
		$I->click("//tr[@data-repeat-index='0']//div[contains(., 'attribute" . msq("ProductAttributeFrontendLabel") . "')]"); // stepKey: clickAttributeSet2
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad2
		$I->comment("Edit fields");
		$I->comment("Enable/Disable Toggle");
		$I->checkOption("//*[@id='container']//input[@name='product[status]']/.."); // stepKey: clickOnEnableDisableToggleAgain
		$I->waitForPageLoad(30); // stepKey: clickOnEnableDisableToggleAgainWaitForPageLoad
		$I->comment("Apply Attribute Set");
		$I->comment("Entering Action Group [startEditAttrSet] AdminSelectAttributeSetOnEditProductPageActionGroup");
		$I->click("div[data-index='attribute_set_id'] .admin__field-control"); // stepKey: clickAttributeSetDropdownStartEditAttrSet
		$I->fillField("div[data-index='attribute_set_id'] .admin__field-control input", "attributeTwo" . msq("ProductAttributeFrontendLabelTwo")); // stepKey: searchForAttributeSetStartEditAttrSet
		$I->waitForPageLoad(30); // stepKey: searchForAttributeSetStartEditAttrSetWaitForPageLoad
		$I->click("div[data-index='attribute_set_id'] .action-menu-item._last"); // stepKey: selectAttributeSetStartEditAttrSet
		$I->waitForPageLoad(30); // stepKey: selectAttributeSetStartEditAttrSetWaitForPageLoad
		$I->comment("Exiting Action Group [startEditAttrSet] AdminSelectAttributeSetOnEditProductPageActionGroup");
		$I->comment("Comment is added to preserve the step key for backward compatibility");
		$I->comment("Comment is added to preserve the step key for backward compatibility");
		$I->comment("Product name and SKU");
		$I->fillField("//*[@name='product[name]']", "BundleProduct2" . msq("BundleProduct")); // stepKey: fillProductName
		$I->fillField("//*[@name='product[sku]']", "bundleproduct2" . msq("BundleProduct")); // stepKey: fillProductSku
		$I->click("//*[@name='product[name]']"); // stepKey: clickUnselectField
		$I->comment("Dynamic SKU Toggle");
		$I->checkOption("div[data-index='sku_type'] .admin__actions-switch-label"); // stepKey: clickOnToggle
		$I->waitForPageLoad(30); // stepKey: clickOnToggleWaitForPageLoad
		$I->click("//*[@name='product[name]']"); // stepKey: clickUnselectFieldAgain
		$I->comment("Fill out price");
		$I->fillField("//div[@data-index='price']//input", "20"); // stepKey: fillOutPrice
		$I->comment("Stock status");
		$I->selectOption("//select[@name='product[quantity_and_stock_status][is_in_stock]']", "Out of Stock"); // stepKey: stockStatus
		$I->comment("Dynamic weight");
		$I->checkOption("//div[@data-index='weight_type']//div[@data-role='switcher']"); // stepKey: dynamicWeight
		$I->waitForPageLoad(30); // stepKey: dynamicWeightWaitForPageLoad
		$I->comment("Visibilty");
		$I->selectOption("//select[@name='product[visibility]']", "Not Visible Individually"); // stepKey: openVisibility
		$I->comment("New from - to");
		$I->fillField("//div[@data-index='news_from_date']//input", "10/20/2018"); // stepKey: fillInFirstDate
		$I->fillField("//div[@data-index='news_to_date']//input", "10/20/2018"); // stepKey: fillInSecondDate
		$I->comment("Country of manufacture");
		$I->selectOption("//select[@name='product[country_of_manufacture]']", "France"); // stepKey: countryOfManufactureDropDown
		$I->comment("Save the product");
		$I->comment("Entering Action Group [clickSaveButton] AdminProductFormSaveActionGroup");
		$I->click("#save-button"); // stepKey: saveProductClickSaveButton
		$I->waitForPageLoad(30); // stepKey: saveProductClickSaveButtonWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForProductSavingClickSaveButton
		$I->comment("Exiting Action Group [clickSaveButton] AdminProductFormSaveActionGroup");
		$I->seeElement(".message-success"); // stepKey: messageYouSavedTheProductIsShown
		$I->comment("Verify form was filled out correctly after edit");
		$I->comment("Enable/Disable Toggle");
		$I->seeElement("//*[@id='container']//input[@name='product[status]' and @value='1']/.."); // stepKey: seeToggleIsOn2
		$I->comment("Attribute Set");
		$I->seeOptionIsSelected("div[data-index='attribute_set_id'] .admin__field-control", "attributeTwo" . msq("ProductAttributeFrontendLabelTwo")); // stepKey: seeAttributeSet2
		$I->comment("Product name and SKU");
		$I->seeInField("//*[@name='product[name]']", "BundleProduct2" . msq("BundleProduct")); // stepKey: seeProductName2
		$I->seeInField("//*[@name='product[sku]']", "bundleproduct2" . msq("BundleProduct")); // stepKey: seeProductSku2
		$I->comment("Dynamic SKU Toggle");
		$I->seeElement("//div[@data-index='sku_type']//div[@data-role='switcher']//input[@value='0']"); // stepKey: seeDynamicSkuToggleOn2
		$I->comment("Tax Class");
		$I->seeOptionIsSelected("//select[@name='product[tax_class_id]']", "Taxable Goods"); // stepKey: seeCorrectTaxClass2
		$I->waitForPageLoad(30); // stepKey: seeCorrectTaxClass2WaitForPageLoad
		$I->comment("Price");
		$I->seeInField("//div[@data-index='price']//input", "20.00"); // stepKey: seePrice2
		$I->comment("Stock status");
		$I->seeOptionIsSelected("//select[@name='product[quantity_and_stock_status][is_in_stock]']", "Out of Stock"); // stepKey: seeStockStatus2
		$I->comment("Dynamic weight");
		$I->seeElement("//div[@data-index='weight_type']//div[@data-role='switcher']//input[@value='0']"); // stepKey: seeDynamicWeightOn2
		$I->comment("Visibilty");
		$I->seeOptionIsSelected("//select[@name='product[visibility]']", "Not Visible Individually"); // stepKey: seeVisibility2
		$I->comment("Categories");
		$I->seeElement("//div[@data-index='category_ids']//div[@class='admin__field-control']"); // stepKey: seeDefaultCategory2
		$I->waitForPageLoad(30); // stepKey: seeDefaultCategory2WaitForPageLoad
		$I->comment("New from - to");
		$I->seeInField("//div[@data-index='news_from_date']//input", "10/20/2018"); // stepKey: seeFirstDate2
		$I->seeInField("//div[@data-index='news_to_date']//input", "10/20/2018"); // stepKey: seeSecondDate2
		$I->comment("Country of manufacture");
		$I->seeOptionIsSelected("//select[@name='product[country_of_manufacture]']", "France"); // stepKey: seeCountryOfManufacture2
	}
}
