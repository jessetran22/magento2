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
 * @Title("MC-19134: Customer should not be able to add a Bundle Product to the cart when added a special price for associated products")
 * @Description("Customer should not be able to add a Bundle Product to the cart when added a special price for associated products<h3>Test files</h3>app/code/Magento/Bundle/Test/Mftf/Test/StorefrontSpecialPriceBundleProductInCartTest.xml<br>")
 * @TestCaseId("MC-19134")
 * @group bundle
 */
class StorefrontSpecialPriceBundleProductInCartTestCest
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
		$I->comment("Create the Simple product with Special price");
		$I->createEntity("simpleProduct", "hook", "SimpleProduct2", [], []); // stepKey: simpleProduct
		$I->createEntity("specialPriceToSimpleProduct", "hook", "specialProductPrice2", ["simpleProduct"], []); // stepKey: specialPriceToSimpleProduct
		$I->comment("Create the bundle product");
		$I->createEntity("bundleProduct", "hook", "ApiBundleProduct", [], []); // stepKey: bundleProduct
		$bundleOptionFields['required'] = "true";
		$I->createEntity("bundleOption", "hook", "RadioButtonsOption", ["bundleProduct"], $bundleOptionFields); // stepKey: bundleOption
		$I->createEntity("linkOptionToProduct", "hook", "ApiBundleLink", ["bundleProduct", "bundleOption", "simpleProduct"], []); // stepKey: linkOptionToProduct
		$I->comment("Run reindex stock status");
		$I->comment("Entering Action Group [reindex] CliIndexerReindexActionGroup");
		$reindexSpecifiedIndexersReindex = $I->magentoCLI("indexer:reindex", 60, "cataloginventory_stock"); // stepKey: reindexSpecifiedIndexersReindex
		$I->comment($reindexSpecifiedIndexersReindex);
		$I->comment("Exiting Action Group [reindex] CliIndexerReindexActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->deleteEntity("bundleProduct", "hook"); // stepKey: deleteBundleProduct
		$I->deleteEntity("simpleProduct", "hook"); // stepKey: deleteSimpleProduct
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
	 * @Stories({"Add bundle product to cart on storefront"})
	 * @Severity(level = SeverityLevel::BLOCKER)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StorefrontSpecialPriceBundleProductInCartTest(AcceptanceTester $I)
	{
		$I->comment("Go to storefront BundleProduct");
		$I->amOnPage("/" . $I->retrieveEntityField('bundleProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: goToStorefront
		$I->comment("Entering Action Group [addProductToCartFirstTime] StorefrontAddBundleProductFromProductToCartActionGroup");
		$I->click("#bundle-slide"); // stepKey: clickCustomizeAndAddToCartAddProductToCartFirstTime
		$I->waitForPageLoad(30); // stepKey: clickCustomizeAndAddToCartAddProductToCartFirstTimeWaitForPageLoad
		$I->click("#product-addtocart-button"); // stepKey: clickAddBundleProductToCartAddProductToCartFirstTime
		$I->waitForPageLoad(30); // stepKey: clickAddBundleProductToCartAddProductToCartFirstTimeWaitForPageLoad
		$I->waitForElementVisible("//header//div[contains(@class, 'minicart-wrapper')]//a[contains(@class, 'showcart')]//span[@class='counter-number']", 30); // stepKey: waitProductCountAddProductToCartFirstTime
		$I->see("You added " . $I->retrieveEntityField('bundleProduct', 'name', 'test') . " to your shopping cart.", "div.message-success.success.message"); // stepKey: seeSuccessMessageAddProductToCartFirstTime
		$I->comment("Exiting Action Group [addProductToCartFirstTime] StorefrontAddBundleProductFromProductToCartActionGroup");
		$I->comment("Entering Action Group [addProductToCartSecondTime] StorefrontAddBundleProductFromProductToCartActionGroup");
		$I->click("#bundle-slide"); // stepKey: clickCustomizeAndAddToCartAddProductToCartSecondTime
		$I->waitForPageLoad(30); // stepKey: clickCustomizeAndAddToCartAddProductToCartSecondTimeWaitForPageLoad
		$I->click("#product-addtocart-button"); // stepKey: clickAddBundleProductToCartAddProductToCartSecondTime
		$I->waitForPageLoad(30); // stepKey: clickAddBundleProductToCartAddProductToCartSecondTimeWaitForPageLoad
		$I->waitForElementVisible("//header//div[contains(@class, 'minicart-wrapper')]//a[contains(@class, 'showcart')]//span[@class='counter-number']", 30); // stepKey: waitProductCountAddProductToCartSecondTime
		$I->see("You added " . $I->retrieveEntityField('bundleProduct', 'name', 'test') . " to your shopping cart.", "div.message-success.success.message"); // stepKey: seeSuccessMessageAddProductToCartSecondTime
		$I->comment("Exiting Action Group [addProductToCartSecondTime] StorefrontAddBundleProductFromProductToCartActionGroup");
		$I->comment("Entering Action Group [openMiniCart] StorefrontClickOnMiniCartActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollToTheTopOfThePageOpenMiniCart
		$I->waitForElementVisible("a.showcart", 30); // stepKey: waitForElementToBeVisibleOpenMiniCart
		$I->waitForPageLoad(60); // stepKey: waitForElementToBeVisibleOpenMiniCartWaitForPageLoad
		$I->click("a.showcart"); // stepKey: clickOnMiniCartOpenMiniCart
		$I->waitForPageLoad(60); // stepKey: clickOnMiniCartOpenMiniCartWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadOpenMiniCart
		$I->comment("Exiting Action Group [openMiniCart] StorefrontClickOnMiniCartActionGroup");
		$I->comment("Entering Action Group [assertSubtotal] AssertStorefrontMiniCartSubtotalActionGroup");
		$I->waitForElementVisible("//div[@class='subtotal']//span/span[@class='price']", 30); // stepKey: waitForSubtotalAssertSubtotal
		$I->see("$111.10", "//div[@class='subtotal']//span/span[@class='price']"); // stepKey: seeSubtotalAssertSubtotal
		$I->comment("Exiting Action Group [assertSubtotal] AssertStorefrontMiniCartSubtotalActionGroup");
	}
}
