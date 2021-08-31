<?php
namespace Magento\AcceptanceTest\_SearchEngineElasticsearchSuite\Backend;

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
 * @Title("MC-40782: Partial word search should be performed on searchable fields only")
 * @Description("Partial word search should be performed on searchable fields only<h3>Test files</h3>app/code/Magento/CatalogSearch/Test/Mftf/Test/StorefrontPartialWordQuickSearchNotSearchableTest.xml<br>")
 * @TestCaseId("MC-40782")
 * @group SearchEngineElasticsearch
 */
class StorefrontPartialWordQuickSearchNotSearchableTestCest
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
        $this->helperContainer->create("Magento\Rule\Test\Mftf\Helper\RuleHelper");
    }
	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _before(AcceptanceTester $I)
	{
		$I->comment("Create category");
		$I->createEntity("newCategory", "hook", "SimpleSubCategory", [], []); // stepKey: newCategory
		$I->comment("Create product1");
		$I->createEntity("product1", "hook", "ProductForPartialSearch", ["newCategory"], []); // stepKey: product1
		$I->comment("Create product2");
		$I->createEntity("product2", "hook", "SimpleProduct", ["newCategory"], []); // stepKey: product2
		$I->comment("Create product3");
		$I->createEntity("product3", "hook", "ApiSimpleProduct", ["newCategory"], []); // stepKey: product3
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
		$I->comment("Open \"Name\" attribute in admin");
		$I->comment("Entering Action Group [OpenNameAttribute] OpenProductAttributeFromSearchResultInGridActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product_attribute"); // stepKey: navigateToProductAttributeGridOpenNameAttribute
		$I->click("button[data-action='grid-filter-reset']"); // stepKey: resetFiltersOnGridOpenNameAttribute
		$I->waitForPageLoad(30); // stepKey: resetFiltersOnGridOpenNameAttributeWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForAdminProductAttributeGridSectionLoadOpenNameAttribute
		$I->fillField("#attributeGrid_filter_attribute_code", "name"); // stepKey: setAttributeCodeOpenNameAttribute
		$I->click("button[data-action=grid-filter-apply]"); // stepKey: searchForAttributeFromTheGridOpenNameAttribute
		$I->waitForPageLoad(30); // stepKey: searchForAttributeFromTheGridOpenNameAttributeWaitForPageLoad
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskOnGridToDisappearOpenNameAttribute
		$I->waitForElementVisible("//td[contains(text(),'name')]", 30); // stepKey: waitForAdminProductAttributeGridLoadOpenNameAttribute
		$I->waitForPageLoad(30); // stepKey: waitForAdminProductAttributeGridLoadOpenNameAttributeWaitForPageLoad
		$I->see("name", "//div[@id='attributeGrid']//td[contains(@class,'col-attr-code col-attribute_code')]"); // stepKey: seeAttributeCodeInGridOpenNameAttribute
		$I->click("//td[contains(text(),'name')]"); // stepKey: clickAttributeToViewOpenNameAttribute
		$I->waitForPageLoad(30); // stepKey: clickAttributeToViewOpenNameAttributeWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForViewAdminProductAttributeLoadOpenNameAttribute
		$I->comment("Exiting Action Group [OpenNameAttribute] OpenProductAttributeFromSearchResultInGridActionGroup");
		$I->comment("Configure \"Name\" attribute as not searchable");
		$I->comment("Entering Action Group [makeNameNotSearchable] AdminSetUseInSearchValueForProductAttributeActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollToTopOfPageMakeNameNotSearchable
		$I->click("#product_attribute_tabs_front"); // stepKey: clickStorefrontPropertiesTabMakeNameNotSearchable
		$I->waitForElementVisible("#is_searchable", 30); // stepKey: waitForUseInSearchElementVisibleMakeNameNotSearchable
		$I->selectOption("#is_searchable", "No"); // stepKey: setUseInSearchValueMakeNameNotSearchable
		$I->comment("Exiting Action Group [makeNameNotSearchable] AdminSetUseInSearchValueForProductAttributeActionGroup");
		$I->comment("Save \"Name\" attribute");
		$I->comment("Entering Action Group [saveAttributeChanges] SaveProductAttributeActionGroup");
		$I->waitForElementVisible("#save", 30); // stepKey: waitForSaveButtonSaveAttributeChanges
		$I->waitForPageLoad(30); // stepKey: waitForSaveButtonSaveAttributeChangesWaitForPageLoad
		$I->click("#save"); // stepKey: clickSaveButtonSaveAttributeChanges
		$I->waitForPageLoad(30); // stepKey: clickSaveButtonSaveAttributeChangesWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForAttributeToSaveSaveAttributeChanges
		$I->seeElement(".message.message-success.success"); // stepKey: seeSuccessMessageSaveAttributeChanges
		$I->comment("Exiting Action Group [saveAttributeChanges] SaveProductAttributeActionGroup");
		$I->comment("Reindex");
		$I->comment("Entering Action Group [reindex] CliIndexerReindexActionGroup");
		$reindexSpecifiedIndexersReindex = $I->magentoCLI("indexer:reindex", 60, ""); // stepKey: reindexSpecifiedIndexersReindex
		$I->comment($reindexSpecifiedIndexersReindex);
		$I->comment("Exiting Action Group [reindex] CliIndexerReindexActionGroup");
		$I->comment("Clean cache");
		$I->comment("Entering Action Group [flushCache] CliCacheCleanActionGroup");
		$cleanSpecifiedCacheFlushCache = $I->magentoCLI("cache:clean", 60, ""); // stepKey: cleanSpecifiedCacheFlushCache
		$I->comment($cleanSpecifiedCacheFlushCache);
		$I->comment("Exiting Action Group [flushCache] CliCacheCleanActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Delete product1");
		$I->deleteEntity("product1", "hook"); // stepKey: deleteProduct1
		$I->comment("Delete product2");
		$I->deleteEntity("product2", "hook"); // stepKey: deleteProduct2
		$I->comment("Delete product3");
		$I->deleteEntity("product3", "hook"); // stepKey: deleteProduct3
		$I->comment("Delete category");
		$I->deleteEntity("newCategory", "hook"); // stepKey: deleteCategory
		$I->comment("Open \"Name\" attribute in admin");
		$I->comment("Entering Action Group [OpenNameAttribute] OpenProductAttributeFromSearchResultInGridActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product_attribute"); // stepKey: navigateToProductAttributeGridOpenNameAttribute
		$I->click("button[data-action='grid-filter-reset']"); // stepKey: resetFiltersOnGridOpenNameAttribute
		$I->waitForPageLoad(30); // stepKey: resetFiltersOnGridOpenNameAttributeWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForAdminProductAttributeGridSectionLoadOpenNameAttribute
		$I->fillField("#attributeGrid_filter_attribute_code", "name"); // stepKey: setAttributeCodeOpenNameAttribute
		$I->click("button[data-action=grid-filter-apply]"); // stepKey: searchForAttributeFromTheGridOpenNameAttribute
		$I->waitForPageLoad(30); // stepKey: searchForAttributeFromTheGridOpenNameAttributeWaitForPageLoad
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskOnGridToDisappearOpenNameAttribute
		$I->waitForElementVisible("//td[contains(text(),'name')]", 30); // stepKey: waitForAdminProductAttributeGridLoadOpenNameAttribute
		$I->waitForPageLoad(30); // stepKey: waitForAdminProductAttributeGridLoadOpenNameAttributeWaitForPageLoad
		$I->see("name", "//div[@id='attributeGrid']//td[contains(@class,'col-attr-code col-attribute_code')]"); // stepKey: seeAttributeCodeInGridOpenNameAttribute
		$I->click("//td[contains(text(),'name')]"); // stepKey: clickAttributeToViewOpenNameAttribute
		$I->waitForPageLoad(30); // stepKey: clickAttributeToViewOpenNameAttributeWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForViewAdminProductAttributeLoadOpenNameAttribute
		$I->comment("Exiting Action Group [OpenNameAttribute] OpenProductAttributeFromSearchResultInGridActionGroup");
		$I->comment("Configure \"Name\" attribute as searchable");
		$I->comment("Entering Action Group [makeNameSearchable] AdminSetUseInSearchValueForProductAttributeActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollToTopOfPageMakeNameSearchable
		$I->click("#product_attribute_tabs_front"); // stepKey: clickStorefrontPropertiesTabMakeNameSearchable
		$I->waitForElementVisible("#is_searchable", 30); // stepKey: waitForUseInSearchElementVisibleMakeNameSearchable
		$I->selectOption("#is_searchable", "Yes"); // stepKey: setUseInSearchValueMakeNameSearchable
		$I->comment("Exiting Action Group [makeNameSearchable] AdminSetUseInSearchValueForProductAttributeActionGroup");
		$I->comment("Configure \"Name\" attribute to be visible in advanced search (this option is automatically turned off when \"use in search\" is off)");
		$I->comment("Entering Action Group [makeNameVisibleInAdvancedSearch] AdminProductAttributeSetVisibleInAdvancedSearchActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollToTopOfPageMakeNameVisibleInAdvancedSearch
		$I->click("#product_attribute_tabs_front"); // stepKey: clickStorefrontPropertiesTabMakeNameVisibleInAdvancedSearch
		$I->waitForElementVisible("#is_visible_in_advanced_search", 30); // stepKey: waitForVisibleInAdvancedSearchElementVisibleMakeNameVisibleInAdvancedSearch
		$I->selectOption("#is_visible_in_advanced_search", "Yes"); // stepKey: setVisibleInAdvancedSearchValueMakeNameVisibleInAdvancedSearch
		$I->comment("Exiting Action Group [makeNameVisibleInAdvancedSearch] AdminProductAttributeSetVisibleInAdvancedSearchActionGroup");
		$I->comment("Save \"Name\" attribute");
		$I->comment("Entering Action Group [saveAttributeChanges] SaveProductAttributeActionGroup");
		$I->waitForElementVisible("#save", 30); // stepKey: waitForSaveButtonSaveAttributeChanges
		$I->waitForPageLoad(30); // stepKey: waitForSaveButtonSaveAttributeChangesWaitForPageLoad
		$I->click("#save"); // stepKey: clickSaveButtonSaveAttributeChanges
		$I->waitForPageLoad(30); // stepKey: clickSaveButtonSaveAttributeChangesWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForAttributeToSaveSaveAttributeChanges
		$I->seeElement(".message.message-success.success"); // stepKey: seeSuccessMessageSaveAttributeChanges
		$I->comment("Exiting Action Group [saveAttributeChanges] SaveProductAttributeActionGroup");
		$I->comment("Clear grid filter");
		$I->comment("Entering Action Group [clearFilter] ClearFiltersAdminDataGridActionGroup");
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clearExistingOrderFiltersClearFilter
		$I->waitForPageLoad(30); // stepKey: clearExistingOrderFiltersClearFilterWaitForPageLoad
		$I->comment("Exiting Action Group [clearFilter] ClearFiltersAdminDataGridActionGroup");
		$I->comment("Logout from admin");
		$I->comment("Entering Action Group [logoutFromAdmin] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogoutFromAdmin
		$I->comment("Exiting Action Group [logoutFromAdmin] AdminLogoutActionGroup");
		$I->comment("Reindex");
		$I->comment("Entering Action Group [reindex] CliIndexerReindexActionGroup");
		$reindexSpecifiedIndexersReindex = $I->magentoCLI("indexer:reindex", 60, ""); // stepKey: reindexSpecifiedIndexersReindex
		$I->comment($reindexSpecifiedIndexersReindex);
		$I->comment("Exiting Action Group [reindex] CliIndexerReindexActionGroup");
		$I->comment("Clean cache");
		$I->comment("Entering Action Group [flushCache] CliCacheCleanActionGroup");
		$cleanSpecifiedCacheFlushCache = $I->magentoCLI("cache:clean", 60, ""); // stepKey: cleanSpecifiedCacheFlushCache
		$I->comment($cleanSpecifiedCacheFlushCache);
		$I->comment("Exiting Action Group [flushCache] CliCacheCleanActionGroup");
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
	 * @Features({"CatalogSearch"})
	 * @Stories({"Partial Word search using Elasticsearch"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StorefrontPartialWordQuickSearchNotSearchableTest(AcceptanceTester $I)
	{
		$I->comment("Navigate to home page");
		$I->comment("Entering Action Group [goToHomePage] StorefrontOpenHomePageActionGroup");
		$I->amOnPage("/"); // stepKey: goToStorefrontPageGoToHomePage
		$I->waitForPageLoad(30); // stepKey: waitForStorefrontPageLoadGoToHomePage
		$I->comment("Exiting Action Group [goToHomePage] StorefrontOpenHomePageActionGroup");
		$I->comment("Search for word \"partial\"");
		$I->comment("Entering Action Group [search1] StorefrontCheckQuickSearchStringActionGroup");
		$I->fillField("#search", "partial"); // stepKey: fillInputSearch1
		$I->submitForm("#search", []); // stepKey: submitQuickSearchSearch1
		$I->seeInCurrentUrl("/catalogsearch/result/"); // stepKey: checkUrlSearch1
		$I->dontSeeInCurrentUrl("form_key="); // stepKey: checkUrlFormKeySearch1
		$I->seeInTitle("Search results for: 'partial'"); // stepKey: assertQuickSearchTitleSearch1
		$I->see("Search results for: 'partial'", ".page-title span"); // stepKey: assertQuickSearchNameSearch1
		$I->comment("Exiting Action Group [search1] StorefrontCheckQuickSearchStringActionGroup");
		$I->comment("Assert that product1 is present in the search result");
		$I->comment("Entering Action Group [seeProduct1] StorefrontAssertProductNameOnProductMainPageActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForTheProductPageToLoadSeeProduct1
		$I->see($I->retrieveEntityField('product1', 'name', 'test'), ".product-item-name"); // stepKey: seeProductNameSeeProduct1
		$I->comment("Exiting Action Group [seeProduct1] StorefrontAssertProductNameOnProductMainPageActionGroup");
		$I->comment("Assert that product2 is not present in the search result");
		$I->comment("Entering Action Group [dontSeeProduct2] AssertStorefrontProductNameIsNotOnProductMainPageActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForTheProductPageToLoadDontSeeProduct2
		$I->dontSee($I->retrieveEntityField('product2', 'name', 'test'), ".product-item-name"); // stepKey: dontSeeProductNameDontSeeProduct2
		$I->comment("Exiting Action Group [dontSeeProduct2] AssertStorefrontProductNameIsNotOnProductMainPageActionGroup");
		$I->comment("Assert that product3 is not present in the search result");
		$I->comment("Entering Action Group [dontSeeProduct3] AssertStorefrontProductNameIsNotOnProductMainPageActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForTheProductPageToLoadDontSeeProduct3
		$I->dontSee($I->retrieveEntityField('product3', 'name', 'test'), ".product-item-name"); // stepKey: dontSeeProductNameDontSeeProduct3
		$I->comment("Exiting Action Group [dontSeeProduct3] AssertStorefrontProductNameIsNotOnProductMainPageActionGroup");
		$I->comment("Search for word \"simple\"");
		$I->comment("Entering Action Group [search2] StorefrontCheckQuickSearchStringActionGroup");
		$I->fillField("#search", "simple"); // stepKey: fillInputSearch2
		$I->submitForm("#search", []); // stepKey: submitQuickSearchSearch2
		$I->seeInCurrentUrl("/catalogsearch/result/"); // stepKey: checkUrlSearch2
		$I->dontSeeInCurrentUrl("form_key="); // stepKey: checkUrlFormKeySearch2
		$I->seeInTitle("Search results for: 'simple'"); // stepKey: assertQuickSearchTitleSearch2
		$I->see("Search results for: 'simple'", ".page-title span"); // stepKey: assertQuickSearchNameSearch2
		$I->comment("Exiting Action Group [search2] StorefrontCheckQuickSearchStringActionGroup");
		$I->comment("Assert that product1 is present in the search result");
		$I->comment("BIC workaround");
		$I->comment("Entering Action Group [seeProduct1c] StorefrontAssertProductNameOnProductMainPageActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForTheProductPageToLoadSeeProduct1c
		$I->see($I->retrieveEntityField('product1', 'name', 'test'), ".product-item-name"); // stepKey: seeProductNameSeeProduct1c
		$I->comment("Exiting Action Group [seeProduct1c] StorefrontAssertProductNameOnProductMainPageActionGroup");
		$I->comment("Assert that product2 is present in the search result");
		$I->comment("Entering Action Group [seeProduct2] StorefrontAssertProductNameOnProductMainPageActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForTheProductPageToLoadSeeProduct2
		$I->see($I->retrieveEntityField('product2', 'name', 'test'), ".product-item-name"); // stepKey: seeProductNameSeeProduct2
		$I->comment("Exiting Action Group [seeProduct2] StorefrontAssertProductNameOnProductMainPageActionGroup");
		$I->comment("Assert that product3 is present in the search result");
		$I->comment("Entering Action Group [seeProduct3] StorefrontAssertProductNameOnProductMainPageActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForTheProductPageToLoadSeeProduct3
		$I->see($I->retrieveEntityField('product3', 'name', 'test'), ".product-item-name"); // stepKey: seeProductNameSeeProduct3
		$I->comment("Exiting Action Group [seeProduct3] StorefrontAssertProductNameOnProductMainPageActionGroup");
		$I->comment("Search for word \"api-sim\"");
		$I->comment("Entering Action Group [search3] StorefrontCheckQuickSearchStringActionGroup");
		$I->fillField("#search", "api-sim"); // stepKey: fillInputSearch3
		$I->submitForm("#search", []); // stepKey: submitQuickSearchSearch3
		$I->seeInCurrentUrl("/catalogsearch/result/"); // stepKey: checkUrlSearch3
		$I->dontSeeInCurrentUrl("form_key="); // stepKey: checkUrlFormKeySearch3
		$I->seeInTitle("Search results for: 'api-sim'"); // stepKey: assertQuickSearchTitleSearch3
		$I->see("Search results for: 'api-sim'", ".page-title span"); // stepKey: assertQuickSearchNameSearch3
		$I->comment("Exiting Action Group [search3] StorefrontCheckQuickSearchStringActionGroup");
		$I->comment("Assert that product1 is not present in the search result");
		$I->comment("Entering Action Group [dontSeeProduct1b] AssertStorefrontProductNameIsNotOnProductMainPageActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForTheProductPageToLoadDontSeeProduct1b
		$I->dontSee($I->retrieveEntityField('product1', 'name', 'test'), ".product-item-name"); // stepKey: dontSeeProductNameDontSeeProduct1b
		$I->comment("Exiting Action Group [dontSeeProduct1b] AssertStorefrontProductNameIsNotOnProductMainPageActionGroup");
		$I->comment("Assert that product2 is not present in the search result");
		$I->comment("Entering Action Group [dontSeeProduct2b] AssertStorefrontProductNameIsNotOnProductMainPageActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForTheProductPageToLoadDontSeeProduct2b
		$I->dontSee($I->retrieveEntityField('product2', 'name', 'test'), ".product-item-name"); // stepKey: dontSeeProductNameDontSeeProduct2b
		$I->comment("Exiting Action Group [dontSeeProduct2b] AssertStorefrontProductNameIsNotOnProductMainPageActionGroup");
		$I->comment("Assert that product3 is present in the search result");
		$I->comment("Entering Action Group [seeProduct3b] StorefrontAssertProductNameOnProductMainPageActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForTheProductPageToLoadSeeProduct3b
		$I->see($I->retrieveEntityField('product3', 'name', 'test'), ".product-item-name"); // stepKey: seeProductNameSeeProduct3b
		$I->comment("Exiting Action Group [seeProduct3b] StorefrontAssertProductNameOnProductMainPageActionGroup");
	}
}
