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
 * @Title("MC-31743: Using ElasticSearch with weight attribute")
 * @Description("Use ElasticSearch for products with weight attributes<h3>Test files</h3>app/code/Magento/Search/Test/Mftf/Test/StorefrontUsingElasticSearchWithWeightAttributeTest.xml<br>")
 * @TestCaseId("MC-31743")
 * @group SearchEngineElasticsearch
 */
class StorefrontUsingElasticSearchWithWeightAttributeTestCest
{
	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _before(AcceptanceTester $I)
	{
		$I->comment("Create Simple Product with weight");
		$I->createEntity("simpleProduct", "hook", "defaultSimpleProduct", [], []); // stepKey: simpleProduct
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
		$I->comment("Delete create product");
		$I->deleteEntity("simpleProduct", "hook"); // stepKey: deleteProduct
		$I->comment("Change attribute property: Use in Search >No");
		$I->comment("Entering Action Group [openWeightProductAttributeInAdmin] OpenProductAttributeFromSearchResultInGridActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product_attribute"); // stepKey: navigateToProductAttributeGridOpenWeightProductAttributeInAdmin
		$I->click("button[data-action='grid-filter-reset']"); // stepKey: resetFiltersOnGridOpenWeightProductAttributeInAdmin
		$I->waitForPageLoad(30); // stepKey: resetFiltersOnGridOpenWeightProductAttributeInAdminWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForAdminProductAttributeGridSectionLoadOpenWeightProductAttributeInAdmin
		$I->fillField("#attributeGrid_filter_attribute_code", "weight"); // stepKey: setAttributeCodeOpenWeightProductAttributeInAdmin
		$I->click("button[data-action=grid-filter-apply]"); // stepKey: searchForAttributeFromTheGridOpenWeightProductAttributeInAdmin
		$I->waitForPageLoad(30); // stepKey: searchForAttributeFromTheGridOpenWeightProductAttributeInAdminWaitForPageLoad
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskOnGridToDisappearOpenWeightProductAttributeInAdmin
		$I->waitForElementVisible("//td[contains(text(),'weight')]", 30); // stepKey: waitForAdminProductAttributeGridLoadOpenWeightProductAttributeInAdmin
		$I->waitForPageLoad(30); // stepKey: waitForAdminProductAttributeGridLoadOpenWeightProductAttributeInAdminWaitForPageLoad
		$I->see("weight", "//div[@id='attributeGrid']//td[contains(@class,'col-attr-code col-attribute_code')]"); // stepKey: seeAttributeCodeInGridOpenWeightProductAttributeInAdmin
		$I->click("//td[contains(text(),'weight')]"); // stepKey: clickAttributeToViewOpenWeightProductAttributeInAdmin
		$I->waitForPageLoad(30); // stepKey: clickAttributeToViewOpenWeightProductAttributeInAdminWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForViewAdminProductAttributeLoadOpenWeightProductAttributeInAdmin
		$I->comment("Exiting Action Group [openWeightProductAttributeInAdmin] OpenProductAttributeFromSearchResultInGridActionGroup");
		$I->comment("Entering Action Group [makeAttributeUnsearchableInAQuickSearch] AdminSetUseInSearchValueForProductAttributeActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollToTopOfPageMakeAttributeUnsearchableInAQuickSearch
		$I->click("#product_attribute_tabs_front"); // stepKey: clickStorefrontPropertiesTabMakeAttributeUnsearchableInAQuickSearch
		$I->waitForElementVisible("#is_searchable", 30); // stepKey: waitForUseInSearchElementVisibleMakeAttributeUnsearchableInAQuickSearch
		$I->selectOption("#is_searchable", "No"); // stepKey: setUseInSearchValueMakeAttributeUnsearchableInAQuickSearch
		$I->comment("Exiting Action Group [makeAttributeUnsearchableInAQuickSearch] AdminSetUseInSearchValueForProductAttributeActionGroup");
		$I->comment("Entering Action Group [saveAttributeChanges] SaveProductAttributeActionGroup");
		$I->waitForElementVisible("#save", 30); // stepKey: waitForSaveButtonSaveAttributeChanges
		$I->waitForPageLoad(30); // stepKey: waitForSaveButtonSaveAttributeChangesWaitForPageLoad
		$I->click("#save"); // stepKey: clickSaveButtonSaveAttributeChanges
		$I->waitForPageLoad(30); // stepKey: clickSaveButtonSaveAttributeChangesWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForAttributeToSaveSaveAttributeChanges
		$I->seeElement(".message.message-success.success"); // stepKey: seeSuccessMessageSaveAttributeChanges
		$I->comment("Exiting Action Group [saveAttributeChanges] SaveProductAttributeActionGroup");
		$I->comment("Entering Action Group [clearFilter] ClearFiltersAdminDataGridActionGroup");
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clearExistingOrderFiltersClearFilter
		$I->waitForPageLoad(30); // stepKey: clearExistingOrderFiltersClearFilterWaitForPageLoad
		$I->comment("Exiting Action Group [clearFilter] ClearFiltersAdminDataGridActionGroup");
		$I->comment("Logout from admin");
		$I->comment("Entering Action Group [logoutFromAdmin] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogoutFromAdmin
		$I->comment("Exiting Action Group [logoutFromAdmin] AdminLogoutActionGroup");
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
	 * @Features({"Search"})
	 * @Stories({"Storefront Search"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StorefrontUsingElasticSearchWithWeightAttributeTest(AcceptanceTester $I)
	{
		$I->comment("Step 2");
		$I->comment("Entering Action Group [openWeightProductAttribute] OpenProductAttributeFromSearchResultInGridActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product_attribute"); // stepKey: navigateToProductAttributeGridOpenWeightProductAttribute
		$I->click("button[data-action='grid-filter-reset']"); // stepKey: resetFiltersOnGridOpenWeightProductAttribute
		$I->waitForPageLoad(30); // stepKey: resetFiltersOnGridOpenWeightProductAttributeWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForAdminProductAttributeGridSectionLoadOpenWeightProductAttribute
		$I->fillField("#attributeGrid_filter_attribute_code", "weight"); // stepKey: setAttributeCodeOpenWeightProductAttribute
		$I->click("button[data-action=grid-filter-apply]"); // stepKey: searchForAttributeFromTheGridOpenWeightProductAttribute
		$I->waitForPageLoad(30); // stepKey: searchForAttributeFromTheGridOpenWeightProductAttributeWaitForPageLoad
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskOnGridToDisappearOpenWeightProductAttribute
		$I->waitForElementVisible("//td[contains(text(),'weight')]", 30); // stepKey: waitForAdminProductAttributeGridLoadOpenWeightProductAttribute
		$I->waitForPageLoad(30); // stepKey: waitForAdminProductAttributeGridLoadOpenWeightProductAttributeWaitForPageLoad
		$I->see("weight", "//div[@id='attributeGrid']//td[contains(@class,'col-attr-code col-attribute_code')]"); // stepKey: seeAttributeCodeInGridOpenWeightProductAttribute
		$I->click("//td[contains(text(),'weight')]"); // stepKey: clickAttributeToViewOpenWeightProductAttribute
		$I->waitForPageLoad(30); // stepKey: clickAttributeToViewOpenWeightProductAttributeWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForViewAdminProductAttributeLoadOpenWeightProductAttribute
		$I->comment("Exiting Action Group [openWeightProductAttribute] OpenProductAttributeFromSearchResultInGridActionGroup");
		$I->comment("Change attribute property: Use in Search >Yes");
		$I->comment("Entering Action Group [makeAttributeSearchableInAQuickSearch] AdminSetUseInSearchValueForProductAttributeActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollToTopOfPageMakeAttributeSearchableInAQuickSearch
		$I->click("#product_attribute_tabs_front"); // stepKey: clickStorefrontPropertiesTabMakeAttributeSearchableInAQuickSearch
		$I->waitForElementVisible("#is_searchable", 30); // stepKey: waitForUseInSearchElementVisibleMakeAttributeSearchableInAQuickSearch
		$I->selectOption("#is_searchable", "Yes"); // stepKey: setUseInSearchValueMakeAttributeSearchableInAQuickSearch
		$I->comment("Exiting Action Group [makeAttributeSearchableInAQuickSearch] AdminSetUseInSearchValueForProductAttributeActionGroup");
		$I->comment("Entering Action Group [saveAttribute] SaveProductAttributeActionGroup");
		$I->waitForElementVisible("#save", 30); // stepKey: waitForSaveButtonSaveAttribute
		$I->waitForPageLoad(30); // stepKey: waitForSaveButtonSaveAttributeWaitForPageLoad
		$I->click("#save"); // stepKey: clickSaveButtonSaveAttribute
		$I->waitForPageLoad(30); // stepKey: clickSaveButtonSaveAttributeWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForAttributeToSaveSaveAttribute
		$I->seeElement(".message.message-success.success"); // stepKey: seeSuccessMessageSaveAttribute
		$I->comment("Exiting Action Group [saveAttribute] SaveProductAttributeActionGroup");
		$I->comment("Step 3");
		$reindexInvalidatedIndices = $I->magentoCron("index", 90); // stepKey: reindexInvalidatedIndices
		$I->comment($reindexInvalidatedIndices);
		$I->comment("Step 4");
		$I->comment("Entering Action Group [clearFPC] CliCacheCleanActionGroup");
		$cleanSpecifiedCacheClearFPC = $I->magentoCLI("cache:clean", 60, "full_page"); // stepKey: cleanSpecifiedCacheClearFPC
		$I->comment($cleanSpecifiedCacheClearFPC);
		$I->comment("Exiting Action Group [clearFPC] CliCacheCleanActionGroup");
		$I->comment("Step 5");
		$I->comment("Entering Action Group [goToStorefront] StorefrontOpenHomePageActionGroup");
		$I->amOnPage("/"); // stepKey: goToStorefrontPageGoToStorefront
		$I->waitForPageLoad(30); // stepKey: waitForStorefrontPageLoadGoToStorefront
		$I->comment("Exiting Action Group [goToStorefront] StorefrontOpenHomePageActionGroup");
		$I->comment("Step 6");
		$I->comment("Entering Action Group [quickSearchByAnyValue] StorefrontCheckQuickSearchStringActionGroup");
		$I->fillField("#search", "exampleTestValue2020"); // stepKey: fillInputQuickSearchByAnyValue
		$I->submitForm("#search", []); // stepKey: submitQuickSearchQuickSearchByAnyValue
		$I->seeInCurrentUrl("/catalogsearch/result/"); // stepKey: checkUrlQuickSearchByAnyValue
		$I->dontSeeInCurrentUrl("form_key="); // stepKey: checkUrlFormKeyQuickSearchByAnyValue
		$I->seeInTitle("Search results for: 'exampleTestValue2020'"); // stepKey: assertQuickSearchTitleQuickSearchByAnyValue
		$I->see("Search results for: 'exampleTestValue2020'", ".page-title span"); // stepKey: assertQuickSearchNameQuickSearchByAnyValue
		$I->comment("Exiting Action Group [quickSearchByAnyValue] StorefrontCheckQuickSearchStringActionGroup");
		$I->see("Your search returned no results.", "div.message div"); // stepKey: seeCantFindProductMessage
	}
}
