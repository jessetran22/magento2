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
 * @Title("MC-14787: User should be able to use Quick Search to find a downloadable product and add it to cart")
 * @Description("Use Quick Search to find downloadable Product and Add to Cart<h3>Test files</h3>app/code/Magento/CatalogSearch/Test/Mftf/Test/SearchEntityResultsTest/QuickSearchAndAddToCartDownloadableTest.xml<br>")
 * @TestCaseId("MC-14787")
 * @group CatalogSearch
 * @group mtf_migrated
 */
class QuickSearchAndAddToCartDownloadableTestCest
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
		$addDownloadableDomain = $I->magentoCLI("downloadable:domains:add example.com static.magento.com", 60); // stepKey: addDownloadableDomain
		$I->comment($addDownloadableDomain);
		$I->createEntity("createCategory", "hook", "_defaultCategory", [], []); // stepKey: createCategory
		$I->createEntity("createProduct", "hook", "DownloadableProductWithOneLink", ["createCategory"], []); // stepKey: createProduct
		$I->createEntity("addDownloadableLink1", "hook", "downloadableLink1", ["createProduct"], []); // stepKey: addDownloadableLink1
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
		$removeDownloadableDomain = $I->magentoCLI("downloadable:domains:remove example.com static.magento.com", 60); // stepKey: removeDownloadableDomain
		$I->comment($removeDownloadableDomain);
		$I->deleteEntity("createProduct", "hook"); // stepKey: deleteProduct
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
	public function QuickSearchAndAddToCartDownloadableTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [goToFrontPage] StorefrontOpenHomePageActionGroup");
		$I->amOnPage("/"); // stepKey: goToStorefrontPageGoToFrontPage
		$I->waitForPageLoad(30); // stepKey: waitForStorefrontPageLoadGoToFrontPage
		$I->comment("Exiting Action Group [goToFrontPage] StorefrontOpenHomePageActionGroup");
		$I->comment("Entering Action Group [searchStorefront] StorefrontCheckQuickSearchStringActionGroup");
		$I->fillField("#search", $I->retrieveEntityField('createProduct', 'name', 'test')); // stepKey: fillInputSearchStorefront
		$I->submitForm("#search", []); // stepKey: submitQuickSearchSearchStorefront
		$I->seeInCurrentUrl("/catalogsearch/result/"); // stepKey: checkUrlSearchStorefront
		$I->dontSeeInCurrentUrl("form_key="); // stepKey: checkUrlFormKeySearchStorefront
		$I->seeInTitle("Search results for: '" . $I->retrieveEntityField('createProduct', 'name', 'test') . "'"); // stepKey: assertQuickSearchTitleSearchStorefront
		$I->see("Search results for: '" . $I->retrieveEntityField('createProduct', 'name', 'test') . "'", ".page-title span"); // stepKey: assertQuickSearchNameSearchStorefront
		$I->comment("Exiting Action Group [searchStorefront] StorefrontCheckQuickSearchStringActionGroup");
		$I->comment("Entering Action Group [addProductToCart] StorefrontAddToCartFromQuickSearchActionGroup");
		$I->scrollTo("//div[contains(@class, 'product-item-info') and .//*[contains(., '" . $I->retrieveEntityField('createProduct', 'name', 'test') . "')]]"); // stepKey: scrollToProductAddProductToCart
		$I->moveMouseOver("//div[contains(@class, 'product-item-info') and .//*[contains(., '" . $I->retrieveEntityField('createProduct', 'name', 'test') . "')]]"); // stepKey: hoverOverProductAddProductToCart
		$I->click("//div[contains(@class, 'product-item-info') and .//*[contains(., '" . $I->retrieveEntityField('createProduct', 'name', 'test') . "')]] //button[contains(@class, 'tocart')]"); // stepKey: addToCartAddProductToCart
		$I->waitForElementVisible("div .message", 30); // stepKey: waitForProductAddedAddProductToCart
		$I->see("You added " . $I->retrieveEntityField('createProduct', 'name', 'test') . " to your shopping cart.", "div .message"); // stepKey: seeAddedToCartMessageAddProductToCart
		$I->comment("Exiting Action Group [addProductToCart] StorefrontAddToCartFromQuickSearchActionGroup");
	}
}
