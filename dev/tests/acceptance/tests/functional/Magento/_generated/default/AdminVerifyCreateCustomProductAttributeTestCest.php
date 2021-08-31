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
 * @Title("MC-26027: Create Custom Product Attribute Dropdown Field (Not Required) from Product Page")
 * @Description("login as admin and create simple product with attribute Dropdown field<h3>Test files</h3>app/code/Magento/Catalog/Test/Mftf/Test/AdminVerifyCreateCustomProductAttributeTest.xml<br>")
 * @TestCaseId("MC-26027")
 * @group mtf_migrated
 * @group catalog
 */
class AdminVerifyCreateCustomProductAttributeTestCest
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
		$I->createEntity("createCategory", "hook", "SimpleSubCategory", [], []); // stepKey: createCategory
		$I->createEntity("createProduct", "hook", "SimpleProduct", ["createCategory"], []); // stepKey: createProduct
		$I->comment("Entering Action Group [loginToAdminPanel] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginToAdminPanel
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginToAdminPanel
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginToAdminPanel
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginToAdminPanel
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginToAdminPanelWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginToAdminPanel
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginToAdminPanel
		$I->comment("Exiting Action Group [loginToAdminPanel] AdminLoginActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->deleteEntity("createCategory", "hook"); // stepKey: deleteCategory
		$I->deleteEntity("createProduct", "hook"); // stepKey: deleteProduct
		$I->comment("Entering Action Group [deleteCreatedAttribute] AdminDeleteProductAttributeByLabelActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product_attribute"); // stepKey: navigateToProductAttributeGridDeleteCreatedAttribute
		$I->waitForPageLoad(30); // stepKey: waitForProductAttributeGridPageLoadDeleteCreatedAttribute
		$I->click("button[data-action='grid-filter-reset']"); // stepKey: resetFiltersOnGridDeleteCreatedAttribute
		$I->waitForPageLoad(30); // stepKey: resetFiltersOnGridDeleteCreatedAttributeWaitForPageLoad
		$I->fillField("//input[@name='frontend_label']", "attribute" . msq("ProductAttributeFrontendLabel")); // stepKey: setAttributeLabelFilterDeleteCreatedAttribute
		$I->click("button[data-action=grid-filter-apply]"); // stepKey: searchForAttributeLabelFromTheGridDeleteCreatedAttribute
		$I->waitForPageLoad(30); // stepKey: searchForAttributeLabelFromTheGridDeleteCreatedAttributeWaitForPageLoad
		$I->click("//*[@id='attributeGrid_table']/tbody/tr[1]"); // stepKey: clickOnAttributeRowDeleteCreatedAttribute
		$I->waitForPageLoad(30); // stepKey: clickOnAttributeRowDeleteCreatedAttributeWaitForPageLoad
		$I->click("#delete"); // stepKey: clickOnDeleteAttributeButtonDeleteCreatedAttribute
		$I->waitForPageLoad(30); // stepKey: clickOnDeleteAttributeButtonDeleteCreatedAttributeWaitForPageLoad
		$I->waitForElementVisible("aside.confirm .modal-content", 30); // stepKey: waitForConfirmationPopUpVisibleDeleteCreatedAttribute
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: clickOnConfirmationButtonDeleteCreatedAttribute
		$I->waitForPageLoad(60); // stepKey: clickOnConfirmationButtonDeleteCreatedAttributeWaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitForSuccessMessageVisibleDeleteCreatedAttribute
		$I->see("You deleted the product attribute.", "#messages div.message-success"); // stepKey: seeAttributeDeleteSuccessMessageDeleteCreatedAttribute
		$I->comment("Exiting Action Group [deleteCreatedAttribute] AdminDeleteProductAttributeByLabelActionGroup");
		$I->comment("Entering Action Group [logoutFromAdminPanel] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogoutFromAdminPanel
		$I->comment("Exiting Action Group [logoutFromAdminPanel] AdminLogoutActionGroup");
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
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminVerifyCreateCustomProductAttributeTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [navigateToProductPage] AdminProductPageOpenByIdActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/edit/id/" . $I->retrieveEntityField('createProduct', 'id', 'test')); // stepKey: goToProductNavigateToProductPage
		$I->comment("Exiting Action Group [navigateToProductPage] AdminProductPageOpenByIdActionGroup");
		$I->comment("Entering Action Group [createDropdownAttribute] AdminStartCreateProductAttributeOnProductPageActionGroup");
		$I->click("#addAttribute"); // stepKey: clickOnAddAttributeCreateDropdownAttribute
		$I->waitForPageLoad(30); // stepKey: clickOnAddAttributeCreateDropdownAttributeWaitForPageLoad
		$I->waitForElementVisible("button[data-index='add_new_attribute_button']", 30); // stepKey: waitForCreateBtnCreateDropdownAttribute
		$I->waitForPageLoad(30); // stepKey: waitForCreateBtnCreateDropdownAttributeWaitForPageLoad
		$I->click("button[data-index='add_new_attribute_button']"); // stepKey: clickCreateNewAttributeButtonCreateDropdownAttribute
		$I->waitForPageLoad(30); // stepKey: clickCreateNewAttributeButtonCreateDropdownAttributeWaitForPageLoad
		$I->waitForElementVisible("input[name='frontend_label[0]']", 30); // stepKey: waitForLabelInputCreateDropdownAttribute
		$I->fillField("input[name='frontend_label[0]']", "attribute" . msq("ProductAttributeFrontendLabel")); // stepKey: fillAttributeLabelCreateDropdownAttribute
		$I->selectOption("select[name='frontend_input']", "Dropdown"); // stepKey: setInputTypeCreateDropdownAttribute
		$I->waitForPageLoad(30); // stepKey: setInputTypeCreateDropdownAttributeWaitForPageLoad
		$I->click("//div[contains(@data-index,'advanced_fieldset')]"); // stepKey: clickOnAdvancedAttributePropertiesCreateDropdownAttribute
		$I->waitForElementVisible("//*[@class='admin__fieldset-wrapper-content admin__collapsible-content _show']//input[@name='attribute_code']", 30); // stepKey: waitForAttributeCodeToVisibleCreateDropdownAttribute
		$I->fillField("//*[@class='admin__fieldset-wrapper-content admin__collapsible-content _show']//input[@name='attribute_code']", "attribute" . msq("newProductAttribute")); // stepKey: fillAttributeCodeCreateDropdownAttribute
		$I->comment("Exiting Action Group [createDropdownAttribute] AdminStartCreateProductAttributeOnProductPageActionGroup");
		$I->scrollTo("//div[contains(@data-index,'front_fieldset')]"); // stepKey: scrollToStorefrontProperties
		$I->click("//div[contains(@data-index,'front_fieldset')]"); // stepKey: clickOnStorefrontProperties
		$I->waitForElementVisible("//input[contains(@name, 'is_searchable')]/..//label", 30); // stepKey: waitForStoreFrontProperties
		$I->checkOption("//input[contains(@name, 'is_searchable')]/..//label"); // stepKey: enableInSearchOption
		$I->checkOption("//input[contains(@name, 'is_visible_in_advanced_search')]/..//label"); // stepKey: enableAdvancedSearch
		$I->checkOption("//input[contains(@name, 'is_visible_on_front')]/..//label"); // stepKey: enableVisibleOnStorefront
		$I->checkOption("//input[contains(@name, 'is_visible_on_front')]/..//label"); // stepKey: enableSortProductListing
		$I->comment("Entering Action Group [createDropdownOption] AdminAddOptionForDropdownAttributeActionGroup");
		$I->scrollTo("//button[contains(@data-action,'add_new_row')]"); // stepKey: scrollToOptionCreateDropdownOption
		$I->waitForPageLoad(30); // stepKey: scrollToOptionCreateDropdownOptionWaitForPageLoad
		$I->click("//button[contains(@data-action,'add_new_row')]"); // stepKey: clickOnAddValueButtonCreateDropdownOption
		$I->waitForPageLoad(30); // stepKey: clickOnAddValueButtonCreateDropdownOptionWaitForPageLoad
		$I->waitForElementVisible("//input[contains(@name,'option[value][option_0][1]')]", 30); // stepKey: waitForDefaultStoreViewToVisibleCreateDropdownOption
		$I->fillField("//input[contains(@name,'option[value][option_0][1]')]", "White" . msq("ProductAttributeOption8")); // stepKey: fillDefaultStoreViewCreateDropdownOption
		$I->fillField("//input[contains(@name,'option[value][option_0][0]')]", "White" . msq("ProductAttributeOption8")); // stepKey: fillAdminFieldCreateDropdownOption
		$I->comment("Exiting Action Group [createDropdownOption] AdminAddOptionForDropdownAttributeActionGroup");
		$I->checkOption("//tr[1]//input[contains(@name,'default[]')]"); // stepKey: selectRadioButton
		$I->click("#save"); // stepKey: clickOnSaveAttribute
		$I->waitForPageLoad(30); // stepKey: clickOnSaveAttributeWaitForPageLoad
		$I->comment("Entering Action Group [saveTheProduct] SaveProductFormActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollTopPageProductSaveTheProduct
		$I->waitForElementVisible("#save-button", 30); // stepKey: waitForSaveProductButtonSaveTheProduct
		$I->waitForPageLoad(30); // stepKey: waitForSaveProductButtonSaveTheProductWaitForPageLoad
		$I->click("#save-button"); // stepKey: clickSaveProductSaveTheProduct
		$I->waitForPageLoad(30); // stepKey: clickSaveProductSaveTheProductWaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitProductSaveSuccessMessageSaveTheProduct
		$I->dontSee(".message-warning"); // stepKey: dontSeeWarningMessageSaveTheProduct
		$I->see("You saved the product.", "#messages div.message-success"); // stepKey: seeSaveConfirmationSaveTheProduct
		$I->comment("Exiting Action Group [saveTheProduct] SaveProductFormActionGroup");
		$I->comment("Entering Action Group [adminProductAssertAttribute] AdminAssertProductAttributeOnProductEditPageActionGroup");
		$I->conditionalClick("//strong[contains(@class, 'admin__collapsible-title')]/span[text()='Attributes']", "//div[contains(@class, 'admin__collapsible-block-wrapper') and contains(@class, '_show') ]//span[text()='Attributes']", false); // stepKey: clickToOpenAdminProductAssertAttribute
		$I->scrollTo("//strong[contains(@class, 'admin__collapsible-title')]/span[text()='Attributes']"); // stepKey: scrollToAttributeTabAdminProductAssertAttribute
		$I->seeElement("//*[@class='admin__field']//span[text()='attribute" . msq("ProductAttributeFrontendLabel") . "']"); // stepKey: seeAttributeLabelInProductFormAdminProductAssertAttribute
		$I->seeElement("//fieldset[@class='admin__fieldset']//div[contains(@data-index,'attribute" . msq("newProductAttribute") . "')]"); // stepKey: seeProductAttributeIsAddedAdminProductAssertAttribute
		$I->comment("Exiting Action Group [adminProductAssertAttribute] AdminAssertProductAttributeOnProductEditPageActionGroup");
		$I->comment("Entering Action Group [searchAttributeByCodeOnProductAttributeGrid] SearchAttributeByCodeOnProductAttributeGridActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product_attribute"); // stepKey: navigateToProductAttributeGridSearchAttributeByCodeOnProductAttributeGrid
		$I->waitForPageLoad(30); // stepKey: waitForAdminProductAttributeGridLoadSearchAttributeByCodeOnProductAttributeGrid
		$I->click("button[data-action='grid-filter-reset']"); // stepKey: resetFiltersOnGridSearchAttributeByCodeOnProductAttributeGrid
		$I->waitForPageLoad(30); // stepKey: resetFiltersOnGridSearchAttributeByCodeOnProductAttributeGridWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForAdminProductAttributeGridSectionLoadSearchAttributeByCodeOnProductAttributeGrid
		$I->fillField("#attributeGrid_filter_attribute_code", "attribute" . msq("newProductAttribute")); // stepKey: setAttributeCodeSearchAttributeByCodeOnProductAttributeGrid
		$I->click("button[data-action=grid-filter-apply]"); // stepKey: searchForAttributeFromTheGridSearchAttributeByCodeOnProductAttributeGrid
		$I->waitForPageLoad(30); // stepKey: searchForAttributeFromTheGridSearchAttributeByCodeOnProductAttributeGridWaitForPageLoad
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskOnGridToDisappearSearchAttributeByCodeOnProductAttributeGrid
		$I->see("attribute" . msq("newProductAttribute"), "//div[@id='attributeGrid']//td[contains(@class,'col-attr-code col-attribute_code')]"); // stepKey: seeAttributeCodeInGridSearchAttributeByCodeOnProductAttributeGrid
		$I->comment("Exiting Action Group [searchAttributeByCodeOnProductAttributeGrid] SearchAttributeByCodeOnProductAttributeGridActionGroup");
		$I->comment("Entering Action Group [assertAttributeOnProductAttributesGrid] AdminAssertProductAttributeInAttributeGridActionGroup");
		$I->see("attribute" . msq("ProductAttributeFrontendLabel"), "//div[@id='attributeGrid']//table[@id='attributeGrid_table']//tbody//td[contains(@class,'col-label col-frontend_label')]"); // stepKey: seeDefaultLabelAssertAttributeOnProductAttributesGrid
		$I->see("Yes", "//div[@id='attributeGrid']//td[contains(@class,'a-center col-is_visible')]"); // stepKey: seeIsVisibleColumnAssertAttributeOnProductAttributesGrid
		$I->see("Yes", "//div[@id='attributeGrid']//td[contains(@class,'a-center col-is_searchable')]"); // stepKey: seeSearchableColumnAssertAttributeOnProductAttributesGrid
		$I->see("No", "//div[@id='attributeGrid']//td[contains(@class,'a-center col-is_comparable')]"); // stepKey: seeComparableColumnAssertAttributeOnProductAttributesGrid
		$I->comment("Exiting Action Group [assertAttributeOnProductAttributesGrid] AdminAssertProductAttributeInAttributeGridActionGroup");
		$I->comment("Entering Action Group [openProductPageOnStorefront] StorefrontOpenProductEntityPageActionGroup");
		$I->amOnPage("/" . $I->retrieveEntityField('createProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: goToProductPageOpenProductPageOnStorefront
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadedOpenProductPageOnStorefront
		$I->comment("Exiting Action Group [openProductPageOnStorefront] StorefrontOpenProductEntityPageActionGroup");
		$I->comment("Entering Action Group [checkProductPriceAndNameInStorefrontProductPage] StorefrontAssertUpdatedProductPriceInStorefrontProductPageActionGroup");
		$I->seeInTitle($I->retrieveEntityField('createProduct', 'name', 'test')); // stepKey: assertProductNameTitleCheckProductPriceAndNameInStorefrontProductPage
		$I->see($I->retrieveEntityField('createProduct', 'name', 'test'), ".base"); // stepKey: assertProductNameCheckProductPriceAndNameInStorefrontProductPage
		$I->see($I->retrieveEntityField('createProduct', 'price', 'test'), "div.price-box.price-final_price"); // stepKey: assertProductPriceCheckProductPriceAndNameInStorefrontProductPage
		$I->comment("Exiting Action Group [checkProductPriceAndNameInStorefrontProductPage] StorefrontAssertUpdatedProductPriceInStorefrontProductPageActionGroup");
		$I->scrollTo("#tab-label-additional-title"); // stepKey: scrollToAttribute
		$I->waitForPageLoad(30); // stepKey: scrollToAttributeWaitForPageLoad
		$I->comment("Entering Action Group [checkAttributeInMoreInformationTab] CheckAttributeInMoreInformationTabActionGroup");
		$I->click("#tab-label-additional-title"); // stepKey: clickTabCheckAttributeInMoreInformationTab
		$I->waitForPageLoad(30); // stepKey: clickTabCheckAttributeInMoreInformationTabWaitForPageLoad
		$I->see("attribute" . msq("ProductAttributeFrontendLabel"), "#additional"); // stepKey: seeAttributeLabelCheckAttributeInMoreInformationTab
		$I->see("white" . msq("ProductAttributeOption8"), "#additional"); // stepKey: seeAttributeValueCheckAttributeInMoreInformationTab
		$I->comment("Exiting Action Group [checkAttributeInMoreInformationTab] CheckAttributeInMoreInformationTabActionGroup");
		$I->comment("Entering Action Group [quickSearchByProductAttribute] StorefrontCheckQuickSearchStringActionGroup");
		$I->fillField("#search", "white" . msq("ProductAttributeOption8")); // stepKey: fillInputQuickSearchByProductAttribute
		$I->submitForm("#search", []); // stepKey: submitQuickSearchQuickSearchByProductAttribute
		$I->seeInCurrentUrl("/catalogsearch/result/"); // stepKey: checkUrlQuickSearchByProductAttribute
		$I->dontSeeInCurrentUrl("form_key="); // stepKey: checkUrlFormKeyQuickSearchByProductAttribute
		$I->seeInTitle("Search results for: 'white" . msq("ProductAttributeOption8") . "'"); // stepKey: assertQuickSearchTitleQuickSearchByProductAttribute
		$I->see("Search results for: 'white" . msq("ProductAttributeOption8") . "'", ".page-title span"); // stepKey: assertQuickSearchNameQuickSearchByProductAttribute
		$I->comment("Exiting Action Group [quickSearchByProductAttribute] StorefrontCheckQuickSearchStringActionGroup");
		$I->comment("Entering Action Group [assertAttributeWithOptionInLayeredNavigation] AssertStorefrontAttributeOptionPresentInLayeredNavigationActionGroup");
		$I->waitForElementVisible("//div[@class='filter-options-title' and contains(text(), 'attribute" . msq("ProductAttributeFrontendLabel") . "')]", 30); // stepKey: waitForAttributeVisibleAssertAttributeWithOptionInLayeredNavigation
		$I->conditionalClick("//div[@class='filter-options-title' and contains(text(), 'attribute" . msq("ProductAttributeFrontendLabel") . "')]", ".filter-options-item.active .items", false); // stepKey: clickToExpandAttributeAssertAttributeWithOptionInLayeredNavigation
		$I->waitForElementVisible(".filter-options-item.active .items", 30); // stepKey: waitForAttributeOptionsVisibleAssertAttributeWithOptionInLayeredNavigation
		$I->see("white" . msq("ProductAttributeOption8"), ".filter-options-item.active .items li:nth-child(1) a"); // stepKey: assertAttributeOptionInLayeredNavigationAssertAttributeWithOptionInLayeredNavigation
		$I->waitForPageLoad(30); // stepKey: assertAttributeOptionInLayeredNavigationAssertAttributeWithOptionInLayeredNavigationWaitForPageLoad
		$I->comment("Exiting Action Group [assertAttributeWithOptionInLayeredNavigation] AssertStorefrontAttributeOptionPresentInLayeredNavigationActionGroup");
		$I->comment("Entering Action Group [assertProductPresentOnSearchPage] StorefrontAssertProductNameOnProductMainPageActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForTheProductPageToLoadAssertProductPresentOnSearchPage
		$I->see($I->retrieveEntityField('createProduct', 'name', 'test'), ".product-item-name"); // stepKey: seeProductNameAssertProductPresentOnSearchPage
		$I->comment("Exiting Action Group [assertProductPresentOnSearchPage] StorefrontAssertProductNameOnProductMainPageActionGroup");
	}
}
