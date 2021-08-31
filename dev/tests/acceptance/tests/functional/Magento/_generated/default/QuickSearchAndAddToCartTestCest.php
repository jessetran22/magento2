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
 * @Title("MC-14784: User should be able to use Quick Search to find a simple product and add it to cart")
 * @Description("Use Quick Search to find simple Product and Add to Cart<h3>Test files</h3>app/code/Magento/CatalogSearch/Test/Mftf/Test/SearchEntityResultsTest/QuickSearchAndAddToCartTest.xml<br>")
 * @TestCaseId("MC-14784")
 * @group CatalogSearch
 * @group mtf_migrated
 */
class QuickSearchAndAddToCartTestCest
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
		$I->createEntity("createCategory", "hook", "_defaultCategory", [], []); // stepKey: createCategory
		$I->createEntity("createSimpleProduct", "hook", "_defaultProduct", ["createCategory"], []); // stepKey: createSimpleProduct
		$I->comment("Adding the comment to replace CliIndexerReindexActionGroup action group ('indexer:reindex' commands) for preserving Backward Compatibility");
		$I->comment("Entering Action Group [flushCache] CliCacheFlushActionGroup");
		$flushSpecifiedCacheFlushCache = $I->magentoCLI("cache:flush", 60, ""); // stepKey: flushSpecifiedCacheFlushCache
		$I->comment($flushSpecifiedCacheFlushCache);
		$I->comment("Exiting Action Group [flushCache] CliCacheFlushActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->deleteEntity("createSimpleProduct", "hook"); // stepKey: deleteProduct
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
	 * @Stories({"Search Product on Storefront"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Features({"CatalogSearch"})
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function QuickSearchAndAddToCartTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [goToFrontPage] StorefrontOpenHomePageActionGroup");
		$I->amOnPage("/"); // stepKey: goToStorefrontPageGoToFrontPage
		$I->waitForPageLoad(30); // stepKey: waitForStorefrontPageLoadGoToFrontPage
		$I->comment("Exiting Action Group [goToFrontPage] StorefrontOpenHomePageActionGroup");
		$I->comment("Entering Action Group [searchStorefront] StorefrontCheckQuickSearchStringActionGroup");
		$I->fillField("#search", $I->retrieveEntityField('createSimpleProduct', 'name', 'test')); // stepKey: fillInputSearchStorefront
		$I->submitForm("#search", []); // stepKey: submitQuickSearchSearchStorefront
		$I->seeInCurrentUrl("/catalogsearch/result/"); // stepKey: checkUrlSearchStorefront
		$I->dontSeeInCurrentUrl("form_key="); // stepKey: checkUrlFormKeySearchStorefront
		$I->seeInTitle("Search results for: '" . $I->retrieveEntityField('createSimpleProduct', 'name', 'test') . "'"); // stepKey: assertQuickSearchTitleSearchStorefront
		$I->see("Search results for: '" . $I->retrieveEntityField('createSimpleProduct', 'name', 'test') . "'", ".page-title span"); // stepKey: assertQuickSearchNameSearchStorefront
		$I->comment("Exiting Action Group [searchStorefront] StorefrontCheckQuickSearchStringActionGroup");
		$I->comment("Entering Action Group [addProductToCart] StorefrontAddToCartFromQuickSearchActionGroup");
		$I->scrollTo("//div[contains(@class, 'product-item-info') and .//*[contains(., '" . $I->retrieveEntityField('createSimpleProduct', 'name', 'test') . "')]]"); // stepKey: scrollToProductAddProductToCart
		$I->moveMouseOver("//div[contains(@class, 'product-item-info') and .//*[contains(., '" . $I->retrieveEntityField('createSimpleProduct', 'name', 'test') . "')]]"); // stepKey: hoverOverProductAddProductToCart
		$I->click("//div[contains(@class, 'product-item-info') and .//*[contains(., '" . $I->retrieveEntityField('createSimpleProduct', 'name', 'test') . "')]] //button[contains(@class, 'tocart')]"); // stepKey: addToCartAddProductToCart
		$I->waitForElementVisible("div .message", 30); // stepKey: waitForProductAddedAddProductToCart
		$I->see("You added " . $I->retrieveEntityField('createSimpleProduct', 'name', 'test') . " to your shopping cart.", "div .message"); // stepKey: seeAddedToCartMessageAddProductToCart
		$I->comment("Exiting Action Group [addProductToCart] StorefrontAddToCartFromQuickSearchActionGroup");
	}
}
