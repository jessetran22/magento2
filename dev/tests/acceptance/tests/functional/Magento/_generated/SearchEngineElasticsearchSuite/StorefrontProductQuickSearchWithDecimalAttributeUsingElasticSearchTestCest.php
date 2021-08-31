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
 * @Title("MC-31239: Search decimal attribute with ElasticSearch")
 * @Description("User should be able to search decimal attribute using ElasticSearch<h3>Test files</h3>app/code/Magento/Elasticsearch/Test/Mftf/Test/StorefrontProductQuickSearchWithDecimalAttributeUsingElasticSearchTest.xml<br>")
 * @TestCaseId("MC-31239")
 * @group SearchEngineElasticsearch
 */
class StorefrontProductQuickSearchWithDecimalAttributeUsingElasticSearchTestCest
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
		$I->comment("Create product attribute with 3 options");
		$I->createEntity("customAttribute", "hook", "multipleSelectProductAttribute", [], []); // stepKey: customAttribute
		$I->createEntity("option1", "hook", "ProductAttributeOption10", ["customAttribute"], []); // stepKey: option1
		$I->createEntity("option2", "hook", "ProductAttributeOption11", ["customAttribute"], []); // stepKey: option2
		$I->createEntity("option3", "hook", "ProductAttributeOption12", ["customAttribute"], []); // stepKey: option3
		$I->comment("Add custom attribute to Default Set");
		$I->createEntity("addToDefaultAttributeSet", "hook", "AddToDefaultSet", ["customAttribute"], []); // stepKey: addToDefaultAttributeSet
		$I->comment("Create subcategory");
		$I->createEntity("newCategory", "hook", "SimpleSubCategory", [], []); // stepKey: newCategory
		$I->createEntity("product1", "hook", "SimpleProduct", ["newCategory", "customAttribute"], []); // stepKey: product1
		$I->createEntity("product2", "hook", "ApiSimpleProduct", ["newCategory", "customAttribute"], []); // stepKey: product2
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
		$I->deleteEntity("product1", "hook"); // stepKey: deleteProduct1
		$I->deleteEntity("product2", "hook"); // stepKey: deleteProduct2
		$I->deleteEntity("newCategory", "hook"); // stepKey: deleteCategory
		$I->comment("Delete attribute");
		$I->deleteEntity("customAttribute", "hook"); // stepKey: deleteCustomAttribute
		$I->comment("Adding the comment to replace CliIndexerReindexActionGroup action group ('indexer:reindex' commands) for preserving Backward Compatibility");
		$I->comment("Entering Action Group [cleanCache] CliCacheCleanActionGroup");
		$cleanSpecifiedCacheCleanCache = $I->magentoCLI("cache:clean", 60, ""); // stepKey: cleanSpecifiedCacheCleanCache
		$I->comment($cleanSpecifiedCacheCleanCache);
		$I->comment("Exiting Action Group [cleanCache] CliCacheCleanActionGroup");
		$I->comment("Entering Action Group [logoutOfAdmin] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogoutOfAdmin
		$I->comment("Exiting Action Group [logoutOfAdmin] AdminLogoutActionGroup");
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
	 * @Features({"Elasticsearch"})
	 * @Stories({"Elasticsearch 7.x.x Upgrade"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StorefrontProductQuickSearchWithDecimalAttributeUsingElasticSearchTest(AcceptanceTester $I)
	{
		$I->comment("Navigate to backend and update value for custom attribute");
		$I->comment("Entering Action Group [searchForSimpleProduct] SearchForProductOnBackendActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: navigateToProductIndexSearchForSimpleProduct
		$I->waitForPageLoad(60); // stepKey: waitForProductsPageToLoadSearchForSimpleProduct
		$I->click("#container > div > div.admin__data-grid-header > div:nth-child(1) > div.data-grid-filters-actions-wrap > div > button"); // stepKey: openFiltersSectionOnProductsPageSearchForSimpleProduct
		$I->conditionalClick("//div[@class='admin__data-grid-header']//button[@class='action-tertiary action-clear']", "//div[@class='admin__data-grid-header']//button[@class='action-tertiary action-clear']", true); // stepKey: cleanFiltersIfTheySetSearchForSimpleProduct
		$I->waitForPageLoad(10); // stepKey: cleanFiltersIfTheySetSearchForSimpleProductWaitForPageLoad
		$I->fillField("input[name=sku]", $I->retrieveEntityField('product1', 'sku', 'test')); // stepKey: fillSkuFieldOnFiltersSectionSearchForSimpleProduct
		$I->click("button[data-action=grid-filter-apply]"); // stepKey: clickApplyFiltersButtonSearchForSimpleProduct
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersButtonSearchForSimpleProductWaitForPageLoad
		$I->comment("Exiting Action Group [searchForSimpleProduct] SearchForProductOnBackendActionGroup");
		$I->comment("Entering Action Group [ModifyCustomAttributeValueProduct1] ModifyCustomAttributeValueActionGroup");
		$I->click("//td[count(../../..//th[./*[.='SKU']]/preceding-sibling::th) + 1][./*[.='" . $I->retrieveEntityField('product1', 'sku', 'test') . "']]"); // stepKey: clickOnSimpleProductRowModifyCustomAttributeValueProduct1
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad1ModifyCustomAttributeValueProduct1
		$I->click("//option[contains(@data-title,'3.5')]"); // stepKey: selectFirstOptionModifyCustomAttributeValueProduct1
		$I->click("#save-button"); // stepKey: saveModifyCustomAttributeValueProduct1
		$I->waitForPageLoad(30); // stepKey: saveModifyCustomAttributeValueProduct1WaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForProductSavedModifyCustomAttributeValueProduct1
		$I->comment("Exiting Action Group [ModifyCustomAttributeValueProduct1] ModifyCustomAttributeValueActionGroup");
		$I->comment("Entering Action Group [searchForApiSimpleProduct] SearchForProductOnBackendActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: navigateToProductIndexSearchForApiSimpleProduct
		$I->waitForPageLoad(60); // stepKey: waitForProductsPageToLoadSearchForApiSimpleProduct
		$I->click("#container > div > div.admin__data-grid-header > div:nth-child(1) > div.data-grid-filters-actions-wrap > div > button"); // stepKey: openFiltersSectionOnProductsPageSearchForApiSimpleProduct
		$I->conditionalClick("//div[@class='admin__data-grid-header']//button[@class='action-tertiary action-clear']", "//div[@class='admin__data-grid-header']//button[@class='action-tertiary action-clear']", true); // stepKey: cleanFiltersIfTheySetSearchForApiSimpleProduct
		$I->waitForPageLoad(10); // stepKey: cleanFiltersIfTheySetSearchForApiSimpleProductWaitForPageLoad
		$I->fillField("input[name=sku]", $I->retrieveEntityField('product2', 'sku', 'test')); // stepKey: fillSkuFieldOnFiltersSectionSearchForApiSimpleProduct
		$I->click("button[data-action=grid-filter-apply]"); // stepKey: clickApplyFiltersButtonSearchForApiSimpleProduct
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersButtonSearchForApiSimpleProductWaitForPageLoad
		$I->comment("Exiting Action Group [searchForApiSimpleProduct] SearchForProductOnBackendActionGroup");
		$I->comment("Entering Action Group [ModifyCustomAttributeValueProduct2] ModifyCustomAttributeValueActionGroup");
		$I->click("//td[count(../../..//th[./*[.='SKU']]/preceding-sibling::th) + 1][./*[.='" . $I->retrieveEntityField('product2', 'sku', 'test') . "']]"); // stepKey: clickOnSimpleProductRowModifyCustomAttributeValueProduct2
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad1ModifyCustomAttributeValueProduct2
		$I->click("//option[contains(@data-title,'10.12')]"); // stepKey: selectFirstOptionModifyCustomAttributeValueProduct2
		$I->click("#save-button"); // stepKey: saveModifyCustomAttributeValueProduct2
		$I->waitForPageLoad(30); // stepKey: saveModifyCustomAttributeValueProduct2WaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForProductSavedModifyCustomAttributeValueProduct2
		$I->comment("Exiting Action Group [ModifyCustomAttributeValueProduct2] ModifyCustomAttributeValueActionGroup");
		$I->comment("Adding the comment to replace CliIndexerReindexActionGroup action group ('indexer:reindex' commands) for preserving Backward Compatibility");
		$I->comment("Entering Action Group [cleanCache] CliCacheCleanActionGroup");
		$cleanSpecifiedCacheCleanCache = $I->magentoCLI("cache:clean", 60, ""); // stepKey: cleanSpecifiedCacheCleanCache
		$I->comment($cleanSpecifiedCacheCleanCache);
		$I->comment("Exiting Action Group [cleanCache] CliCacheCleanActionGroup");
		$I->comment("Entering Action Group [goToHomePage] StorefrontOpenHomePageActionGroup");
		$I->amOnPage("/"); // stepKey: goToStorefrontPageGoToHomePage
		$I->waitForPageLoad(30); // stepKey: waitForStorefrontPageLoadGoToHomePage
		$I->comment("Exiting Action Group [goToHomePage] StorefrontOpenHomePageActionGroup");
		$I->comment("Navigate to Storefront and search");
		$I->comment("Entering Action Group [assertSearchResult0] AssertSearchResultActionGroup");
		$I->fillField("#search", $I->retrieveEntityField('product1', 'name', 'test')); // stepKey: fillSearchBarAssertSearchResult0
		$I->waitForPageLoad(30); // stepKey: waitForSearchButtonAssertSearchResult0
		$I->click("button.action.search"); // stepKey: clickSearchButtonAssertSearchResult0
		$I->waitForPageLoad(30); // stepKey: clickSearchButtonAssertSearchResult0WaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAssertSearchResult0
		$I->seeInCurrentUrl("/catalogsearch/result/"); // stepKey: checkUrlAssertSearchResult0
		$I->seeElement("//a[@class='product-item-link'][contains(text(), '" . $I->retrieveEntityField('product1', 'name', 'test') . "')]"); // stepKey: foundProductAOnPageAssertSearchResult0
		$I->comment("Exiting Action Group [assertSearchResult0] AssertSearchResultActionGroup");
		$I->comment("Entering Action Group [assertSearchResult1] AssertSearchResultActionGroup");
		$I->fillField("#search", "3.5"); // stepKey: fillSearchBarAssertSearchResult1
		$I->waitForPageLoad(30); // stepKey: waitForSearchButtonAssertSearchResult1
		$I->click("button.action.search"); // stepKey: clickSearchButtonAssertSearchResult1
		$I->waitForPageLoad(30); // stepKey: clickSearchButtonAssertSearchResult1WaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAssertSearchResult1
		$I->seeInCurrentUrl("/catalogsearch/result/"); // stepKey: checkUrlAssertSearchResult1
		$I->seeElement("//a[@class='product-item-link'][contains(text(), '" . $I->retrieveEntityField('product1', 'name', 'test') . "')]"); // stepKey: foundProductAOnPageAssertSearchResult1
		$I->comment("Exiting Action Group [assertSearchResult1] AssertSearchResultActionGroup");
		$I->comment("Entering Action Group [assertSearchResult2] AssertSearchResultActionGroup");
		$I->fillField("#search", "10.12"); // stepKey: fillSearchBarAssertSearchResult2
		$I->waitForPageLoad(30); // stepKey: waitForSearchButtonAssertSearchResult2
		$I->click("button.action.search"); // stepKey: clickSearchButtonAssertSearchResult2
		$I->waitForPageLoad(30); // stepKey: clickSearchButtonAssertSearchResult2WaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAssertSearchResult2
		$I->seeInCurrentUrl("/catalogsearch/result/"); // stepKey: checkUrlAssertSearchResult2
		$I->seeElement("//a[@class='product-item-link'][contains(text(), '" . $I->retrieveEntityField('product2', 'name', 'test') . "')]"); // stepKey: foundProductAOnPageAssertSearchResult2
		$I->comment("Exiting Action Group [assertSearchResult2] AssertSearchResultActionGroup");
	}
}
