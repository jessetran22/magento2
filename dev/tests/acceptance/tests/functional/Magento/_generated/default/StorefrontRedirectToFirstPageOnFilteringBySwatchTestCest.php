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
 * @Title("[NO TESTCASEID]: Customers are redirected to first plp page after filtering by swatch")
 * @Description("Customers are redirected to first plp page after filtering by swatch<h3>Test files</h3>app/code/Magento/Swatches/Test/Mftf/Test/StorefrontRedirectToFirstPageOnFilteringBySwatchTest.xml<br>")
 * @group Swatches
 */
class StorefrontRedirectToFirstPageOnFilteringBySwatchTestCest
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
		$I->createEntity("createCategory", "hook", "SimpleSubCategory", [], []); // stepKey: createCategory
		$I->createEntity("createSimpleProduct1", "hook", "SimpleProduct", ["createCategory"], []); // stepKey: createSimpleProduct1
		$I->createEntity("createSimpleProduct2", "hook", "SimpleProduct", ["createCategory"], []); // stepKey: createSimpleProduct2
		$I->createEntity("createSimpleProduct3", "hook", "SimpleProduct", ["createCategory"], []); // stepKey: createSimpleProduct3
		$setOneProductPerPage = $I->magentoCLI("config:set catalog/frontend/grid_per_page 1", 60); // stepKey: setOneProductPerPage
		$I->comment($setOneProductPerPage);
		$setGridPerPage = $I->magentoCLI("config:set catalog/frontend/grid_per_page_values 1", 60); // stepKey: setGridPerPage
		$I->comment($setGridPerPage);
		$I->comment("Entering Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin
		$I->comment("Exiting Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->comment("Entering Action Group [addSwatchAttribute] AddTextSwatchToProductActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product_attribute/new/"); // stepKey: goToNewProductAttributePageAddSwatchAttribute
		$I->waitForPageLoad(30); // stepKey: waitForNewProductAttributePageAddSwatchAttribute
		$I->fillField("#attribute_label", "TextSwatchAttr" . msq("textSwatchAttribute")); // stepKey: fillDefaultLabelAddSwatchAttribute
		$I->selectOption("#frontend_input", "Text Swatch"); // stepKey: selectInputTypeAddSwatchAttribute
		$I->click("#add_new_swatch_text_option_button"); // stepKey: clickAddSwatch1AddSwatchAttribute
		$I->fillField("input[name='swatchtext[value][option_0][0]']", "textSwatchOption1"); // stepKey: fillSwatch1AddSwatchAttribute
		$I->fillField("input[name='optiontext[value][option_0][0]']", "textSwatchOption1"); // stepKey: fillSwatch1DescriptionAddSwatchAttribute
		$I->click("#add_new_swatch_text_option_button"); // stepKey: clickAddSwatch2AddSwatchAttribute
		$I->fillField("input[name='swatchtext[value][option_1][0]']", "textSwatchOption2"); // stepKey: fillSwatch2AddSwatchAttribute
		$I->fillField("input[name='optiontext[value][option_1][0]']", "textSwatchOption2"); // stepKey: fillSwatch2DescriptionAddSwatchAttribute
		$I->click("#add_new_swatch_text_option_button"); // stepKey: clickAddSwatch3AddSwatchAttribute
		$I->fillField("input[name='swatchtext[value][option_2][0]']", "textSwatchOption3"); // stepKey: fillSwatch3AddSwatchAttribute
		$I->fillField("input[name='optiontext[value][option_2][0]']", "textSwatchOption3"); // stepKey: fillSwatch3DescriptionAddSwatchAttribute
		$I->click("#advanced_fieldset-wrapper"); // stepKey: expandAdvancedPropertiesAddSwatchAttribute
		$I->selectOption("#is_global", "1"); // stepKey: selectGlobalScopeAddSwatchAttribute
		$I->fillField("#attribute_code", "text_swatch_attr" . msq("textSwatchAttribute")); // stepKey: fillAttributeCodeFieldAddSwatchAttribute
		$I->scrollToTopOfPage(); // stepKey: scrollToTabsAddSwatchAttribute
		$I->click("#product_attribute_tabs_front"); // stepKey: clickStorefrontPropertiesTabAddSwatchAttribute
		$I->waitForElementVisible("#used_in_product_listing", 30); // stepKey: waitForTabSwitchAddSwatchAttribute
		$I->selectOption("#used_in_product_listing", "No"); // stepKey: useInProductListingAddSwatchAttribute
		$I->selectOption("#is_filterable", "1"); // stepKey: useInLayeredNavigationAddSwatchAttribute
		$I->click("#save_and_edit_button"); // stepKey: clickSaveAddSwatchAttribute
		$I->waitForPageLoad(30); // stepKey: clickSaveAddSwatchAttributeWaitForPageLoad
		$I->comment("Exiting Action Group [addSwatchAttribute] AddTextSwatchToProductActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [deleteSwatchAttribute] DeleteProductAttributeActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product_attribute"); // stepKey: navigateToProductAttributeGridDeleteSwatchAttribute
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clearExistingFiltersDeleteSwatchAttribute
		$I->waitForPageLoad(30); // stepKey: clearExistingFiltersDeleteSwatchAttributeWaitForPageLoad
		$I->fillField("#attributeGrid_filter_attribute_code", "text_swatch_attr" . msq("textSwatchAttribute")); // stepKey: setAttributeCodeDeleteSwatchAttribute
		$I->click("button[data-action=grid-filter-apply]"); // stepKey: searchForAttributeFromTheGridDeleteSwatchAttribute
		$I->waitForPageLoad(30); // stepKey: searchForAttributeFromTheGridDeleteSwatchAttributeWaitForPageLoad
		$I->click("//*[@id='attributeGrid_table']/tbody/tr[1]"); // stepKey: clickOnAttributeRowDeleteSwatchAttribute
		$I->waitForPageLoad(30); // stepKey: clickOnAttributeRowDeleteSwatchAttributeWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad2DeleteSwatchAttribute
		$I->click("#delete"); // stepKey: deleteAttributeDeleteSwatchAttribute
		$I->waitForPageLoad(30); // stepKey: deleteAttributeDeleteSwatchAttributeWaitForPageLoad
		$I->click("//footer[@class='modal-footer']/button[contains(@class, 'action-accept')]"); // stepKey: ClickOnDeleteButtonDeleteSwatchAttribute
		$I->waitForPageLoad(30); // stepKey: ClickOnDeleteButtonDeleteSwatchAttributeWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadDeleteSwatchAttribute
		$I->seeElement(".message.message-success.success"); // stepKey: waitForSuccessMessageDeleteSwatchAttribute
		$I->comment("Exiting Action Group [deleteSwatchAttribute] DeleteProductAttributeActionGroup");
		$I->comment("Entering Action Group [adminLogout] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageAdminLogout
		$I->comment("Exiting Action Group [adminLogout] AdminLogoutActionGroup");
		$setDefaultProductsPerPage = $I->magentoCLI("config:set catalog/frontend/grid_per_page 12", 60); // stepKey: setDefaultProductsPerPage
		$I->comment($setDefaultProductsPerPage);
		$setDefaultGridPerPage = $I->magentoCLI("config:set catalog/frontend/grid_per_page_values 12,24,36", 60); // stepKey: setDefaultGridPerPage
		$I->comment($setDefaultGridPerPage);
		$cleanInvalidatedCaches = $I->magentoCLI("cache:clean config full_page", 60); // stepKey: cleanInvalidatedCaches
		$I->comment($cleanInvalidatedCaches);
		$I->deleteEntity("createCategory", "hook"); // stepKey: deleteCategory
		$I->deleteEntity("createSimpleProduct1", "hook"); // stepKey: deleteSimpleProduct1
		$I->deleteEntity("createSimpleProduct2", "hook"); // stepKey: deleteSimpleProduct2
		$I->deleteEntity("createSimpleProduct3", "hook"); // stepKey: deleteSimpleProduct3
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
	 * @Features({"Swatches"})
	 * @Stories({"Filter by swatch attribute on plp layered navigation"})
	 * @Severity(level = SeverityLevel::TRIVIAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StorefrontRedirectToFirstPageOnFilteringBySwatchTest(AcceptanceTester $I)
	{
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product_set/edit/id/4/"); // stepKey: onAttributeSetEdit
		$I->comment("Entering Action Group [assignAttributeToGroup] AssignAttributeToGroupActionGroup");
		$I->conditionalClick("//*[@id='tree-div1']//span[text()='Product Details']", "//*[@id='tree-div1']//span[text()='Product Details']/parent::*/parent::*[contains(@class, 'collapsed')]", true); // stepKey: extendGroupAssignAttributeToGroup
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad1AssignAttributeToGroup
		$I->dragAndDrop("//*[@id='tree-div2']//span[text()='text_swatch_attr" . msq("textSwatchAttribute") . "']", "//*[@id='tree-div1']//span[text()='Product Details']/parent::*/parent::*/parent::*//li[1]//a/span"); // stepKey: dragAndDropToGroupProductDetailsAssignAttributeToGroup
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad2AssignAttributeToGroup
		$I->see("text_swatch_attr" . msq("textSwatchAttribute"), "#tree-div1"); // stepKey: seeAttributeInGroupAssignAttributeToGroup
		$I->comment("Exiting Action Group [assignAttributeToGroup] AssignAttributeToGroupActionGroup");
		$I->comment("Entering Action Group [SaveAttributeSet] SaveAttributeSetActionGroup");
		$I->click("button[title='Save']"); // stepKey: clickSaveSaveAttributeSet
		$I->waitForPageLoad(30); // stepKey: clickSaveSaveAttributeSetWaitForPageLoad
		$I->see("You saved the attribute set", "#messages div.message-success"); // stepKey: successMessageSaveAttributeSet
		$I->comment("Exiting Action Group [SaveAttributeSet] SaveAttributeSetActionGroup");
		$I->comment("Entering Action Group [goToProductIndexPage] AdminOpenProductIndexPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: goToProductIndexPageGoToProductIndexPage
		$I->waitForPageLoad(30); // stepKey: waitForProductIndexPageLoadGoToProductIndexPage
		$I->comment("Exiting Action Group [goToProductIndexPage] AdminOpenProductIndexPageActionGroup");
		$I->comment("Entering Action Group [clearFiltersOnProductIndexPage] ClearFiltersAdminProductGridActionGroup");
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersClearFiltersOnProductIndexPage
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersClearFiltersOnProductIndexPageWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForGridLoadClearFiltersOnProductIndexPage
		$I->comment("Exiting Action Group [clearFiltersOnProductIndexPage] ClearFiltersAdminProductGridActionGroup");
		$I->comment("Entering Action Group [goToProduct1EditPage] OpenEditProductOnBackendActionGroup");
		$I->click("//td[count(../../..//th[./*[.='SKU']]/preceding-sibling::th) + 1][./*[.='" . $I->retrieveEntityField('createSimpleProduct1', 'sku', 'test') . "']]"); // stepKey: clickOnProductRowGoToProduct1EditPage
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadGoToProduct1EditPage
		$I->seeInField(".admin__field[data-index=sku] input", $I->retrieveEntityField('createSimpleProduct1', 'sku', 'test')); // stepKey: seeProductSkuOnEditProductPageGoToProduct1EditPage
		$I->comment("Exiting Action Group [goToProduct1EditPage] OpenEditProductOnBackendActionGroup");
		$I->selectOption("div[data-index='text_swatch_attr" . msq("textSwatchAttribute") . "'] .admin__field-control select", "textSwatchOption1"); // stepKey: selectProduct1AttributeOption
		$I->comment("Entering Action Group [saveProduct1] SaveProductFormActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollTopPageProductSaveProduct1
		$I->waitForElementVisible("#save-button", 30); // stepKey: waitForSaveProductButtonSaveProduct1
		$I->waitForPageLoad(30); // stepKey: waitForSaveProductButtonSaveProduct1WaitForPageLoad
		$I->click("#save-button"); // stepKey: clickSaveProductSaveProduct1
		$I->waitForPageLoad(30); // stepKey: clickSaveProductSaveProduct1WaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitProductSaveSuccessMessageSaveProduct1
		$I->dontSee(".message-warning"); // stepKey: dontSeeWarningMessageSaveProduct1
		$I->see("You saved the product.", "#messages div.message-success"); // stepKey: seeSaveConfirmationSaveProduct1
		$I->comment("Exiting Action Group [saveProduct1] SaveProductFormActionGroup");
		$I->comment("Entering Action Group [goToProductsGridPage2] AdminOpenProductIndexPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: goToProductIndexPageGoToProductsGridPage2
		$I->waitForPageLoad(30); // stepKey: waitForProductIndexPageLoadGoToProductsGridPage2
		$I->comment("Exiting Action Group [goToProductsGridPage2] AdminOpenProductIndexPageActionGroup");
		$I->comment("Entering Action Group [goToProduct2EditPage] OpenEditProductOnBackendActionGroup");
		$I->click("//td[count(../../..//th[./*[.='SKU']]/preceding-sibling::th) + 1][./*[.='" . $I->retrieveEntityField('createSimpleProduct2', 'sku', 'test') . "']]"); // stepKey: clickOnProductRowGoToProduct2EditPage
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadGoToProduct2EditPage
		$I->seeInField(".admin__field[data-index=sku] input", $I->retrieveEntityField('createSimpleProduct2', 'sku', 'test')); // stepKey: seeProductSkuOnEditProductPageGoToProduct2EditPage
		$I->comment("Exiting Action Group [goToProduct2EditPage] OpenEditProductOnBackendActionGroup");
		$I->selectOption("div[data-index='text_swatch_attr" . msq("textSwatchAttribute") . "'] .admin__field-control select", "textSwatchOption1"); // stepKey: selectProduct2AttributeOption
		$I->comment("Entering Action Group [saveProduct2] SaveProductFormActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollTopPageProductSaveProduct2
		$I->waitForElementVisible("#save-button", 30); // stepKey: waitForSaveProductButtonSaveProduct2
		$I->waitForPageLoad(30); // stepKey: waitForSaveProductButtonSaveProduct2WaitForPageLoad
		$I->click("#save-button"); // stepKey: clickSaveProductSaveProduct2
		$I->waitForPageLoad(30); // stepKey: clickSaveProductSaveProduct2WaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitProductSaveSuccessMessageSaveProduct2
		$I->dontSee(".message-warning"); // stepKey: dontSeeWarningMessageSaveProduct2
		$I->see("You saved the product.", "#messages div.message-success"); // stepKey: seeSaveConfirmationSaveProduct2
		$I->comment("Exiting Action Group [saveProduct2] SaveProductFormActionGroup");
		$I->comment("Entering Action Group [goToProductsGridPage3] AdminOpenProductIndexPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: goToProductIndexPageGoToProductsGridPage3
		$I->waitForPageLoad(30); // stepKey: waitForProductIndexPageLoadGoToProductsGridPage3
		$I->comment("Exiting Action Group [goToProductsGridPage3] AdminOpenProductIndexPageActionGroup");
		$I->comment("Entering Action Group [goToProduct3EditPage] OpenEditProductOnBackendActionGroup");
		$I->click("//td[count(../../..//th[./*[.='SKU']]/preceding-sibling::th) + 1][./*[.='" . $I->retrieveEntityField('createSimpleProduct3', 'sku', 'test') . "']]"); // stepKey: clickOnProductRowGoToProduct3EditPage
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadGoToProduct3EditPage
		$I->seeInField(".admin__field[data-index=sku] input", $I->retrieveEntityField('createSimpleProduct3', 'sku', 'test')); // stepKey: seeProductSkuOnEditProductPageGoToProduct3EditPage
		$I->comment("Exiting Action Group [goToProduct3EditPage] OpenEditProductOnBackendActionGroup");
		$I->selectOption("div[data-index='text_swatch_attr" . msq("textSwatchAttribute") . "'] .admin__field-control select", "textSwatchOption2"); // stepKey: selectProduct3AttributeOption
		$I->comment("Entering Action Group [saveProduct3] SaveProductFormActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollTopPageProductSaveProduct3
		$I->waitForElementVisible("#save-button", 30); // stepKey: waitForSaveProductButtonSaveProduct3
		$I->waitForPageLoad(30); // stepKey: waitForSaveProductButtonSaveProduct3WaitForPageLoad
		$I->click("#save-button"); // stepKey: clickSaveProductSaveProduct3
		$I->waitForPageLoad(30); // stepKey: clickSaveProductSaveProduct3WaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitProductSaveSuccessMessageSaveProduct3
		$I->dontSee(".message-warning"); // stepKey: dontSeeWarningMessageSaveProduct3
		$I->see("You saved the product.", "#messages div.message-success"); // stepKey: seeSaveConfirmationSaveProduct3
		$I->comment("Exiting Action Group [saveProduct3] SaveProductFormActionGroup");
		$runCronIndexer = $I->magentoCron("index", 90); // stepKey: runCronIndexer
		$I->comment($runCronIndexer);
		$I->comment("Entering Action Group [navigateToCategoryPage] StorefrontNavigateCategoryPageActionGroup");
		$I->comment("Open category page on storefront");
		$I->amOnPage("/" . $I->retrieveEntityField('createCategory', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: navigateStorefrontCategoryPageNavigateToCategoryPage
		$I->waitForPageLoad(30); // stepKey: waitForCategoryPageLoadNavigateToCategoryPage
		$I->comment("Exiting Action Group [navigateToCategoryPage] StorefrontNavigateCategoryPageActionGroup");
		$I->comment("Entering Action Group [navigateToCategoryNextPage] StorefrontNavigateCategoryNextPageActionGroup");
		$I->scrollTo(".//*[@class='toolbar toolbar-products'][2]//a[contains(@class, 'next')]"); // stepKey: scrollToNextButtonNavigateToCategoryNextPage
		$I->waitForPageLoad(30); // stepKey: scrollToNextButtonNavigateToCategoryNextPageWaitForPageLoad
		$I->click(".//*[@class='toolbar toolbar-products'][2]//a[contains(@class, 'next')]"); // stepKey: clickOnNextPageNavigateToCategoryNextPage
		$I->waitForPageLoad(30); // stepKey: clickOnNextPageNavigateToCategoryNextPageWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForNextCategoryPageLoadNavigateToCategoryNextPage
		$I->comment("Exiting Action Group [navigateToCategoryNextPage] StorefrontNavigateCategoryNextPageActionGroup");
		$I->click("//div[@class='filter-options-title'][text() = 'TextSwatchAttr" . msq("textSwatchAttribute") . "']"); // stepKey: expandAttribute
		$I->waitForPageLoad(30); // stepKey: expandAttributeWaitForPageLoad
		$I->click("div.text_swatch_attr" . msq("textSwatchAttribute") . " a:nth-of-type(1) div"); // stepKey: filterBySwatch1
		$I->waitForPageLoad(30); // stepKey: filterBySwatch1WaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoad2
		$I->comment("Entering Action Group [assertCurrentPageIsFirst] AssertStorefrontCategoryCurrentPageIsNthActionGroup");
		$currentPageTextAssertCurrentPageIsFirst = $I->grabTextFrom(".//*[@class='toolbar toolbar-products'][2]//li[contains(@class, 'current')]//span[2]"); // stepKey: currentPageTextAssertCurrentPageIsFirst
		$I->waitForPageLoad(30); // stepKey: currentPageTextAssertCurrentPageIsFirstWaitForPageLoad
		$I->assertEquals("1", $currentPageTextAssertCurrentPageIsFirst); // stepKey: assertIsPageNthAssertCurrentPageIsFirst
		$I->comment("Exiting Action Group [assertCurrentPageIsFirst] AssertStorefrontCategoryCurrentPageIsNthActionGroup");
	}
}
