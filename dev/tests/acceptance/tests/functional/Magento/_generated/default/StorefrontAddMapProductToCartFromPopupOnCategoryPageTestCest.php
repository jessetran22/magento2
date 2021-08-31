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
 * @Title("MC-40419: Add simple product with minimum advertised price to cart from popup on category page")
 * @Description("Check that simple product with minimum advertised price is successfully added to cart from popup on category page<h3>Test files</h3>app/code/Magento/Msrp/Test/Mftf/Test/StorefrontAddMapProductToCartFromPopupOnCategoryPageTest.xml<br>")
 * @TestCaseId("MC-40419")
 * @group msrp
 */
class StorefrontAddMapProductToCartFromPopupOnCategoryPageTestCest
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
		$I->comment("Enable Minimum advertised Price");
		$I->createEntity("enableMAP", "hook", "MsrpEnableMAP", [], []); // stepKey: enableMAP
		$I->comment("Display Price in Popup");
		$I->createEntity("displayPriceOnGesture", "hook", "MsrpDisplayPriceOnGesture", [], []); // stepKey: displayPriceOnGesture
		$I->comment("Create category");
		$I->createEntity("createCategory", "hook", "_defaultCategory", [], []); // stepKey: createCategory
		$I->comment("Create product with MAP");
		$I->createEntity("createProduct", "hook", "SimpleProductWithMsrp", ["createCategory"], []); // stepKey: createProduct
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Delete product and category");
		$I->deleteEntity("createProduct", "hook"); // stepKey: deleteProduct
		$I->deleteEntity("createCategory", "hook"); // stepKey: deleteCategory
		$I->comment("Disable Minimum advertised Price");
		$I->createEntity("disableMAP", "hook", "MsrpDisableMAP", [], []); // stepKey: disableMAP
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
	 * @Features({"Msrp"})
	 * @Stories({"Minimum advertised price"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StorefrontAddMapProductToCartFromPopupOnCategoryPageTest(AcceptanceTester $I)
	{
		$I->comment("Open created category on Storefront");
		$I->comment("Entering Action Group [navigateToCategoryPage] StorefrontNavigateCategoryPageActionGroup");
		$I->comment("Open category page on storefront");
		$I->amOnPage("/" . $I->retrieveEntityField('createCategory', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: navigateStorefrontCategoryPageNavigateToCategoryPage
		$I->waitForPageLoad(30); // stepKey: waitForCategoryPageLoadNavigateToCategoryPage
		$I->comment("Exiting Action Group [navigateToCategoryPage] StorefrontNavigateCategoryPageActionGroup");
		$I->comment("Grab and verify MAP price");
		$grabMapPrice = $I->grabTextFrom("//a[normalize-space() = '" . $I->retrieveEntityField('createProduct', 'name', 'test') . "']/following::div[@data-role='priceBox']//span[contains(@class, 'price-msrp_price')]"); // stepKey: grabMapPrice
		$I->waitForPageLoad(30); // stepKey: grabMapPriceWaitForPageLoad
		$I->assertEquals("$111.11", $grabMapPrice); // stepKey: assertMapPrice
		$I->comment("Open 'Click for price' popup and click 'Add to Cart' button");
		$I->click("//a[normalize-space() = '" . $I->retrieveEntityField('createProduct', 'name', 'test') . "']/following::div[@data-role='priceBox']/a[@class='action map-show-info']"); // stepKey: clickForPrice
		$I->waitForPageLoad(30); // stepKey: clickForPriceWaitForPageLoad
		$I->waitForElementVisible("#map-popup-click-for-price .action.tocart", 30); // stepKey: waitForAddToCartButton
		$I->waitForPageLoad(30); // stepKey: waitForAddToCartButtonWaitForPageLoad
		$I->click("#map-popup-click-for-price .action.tocart"); // stepKey: clickAddToCartButton
		$I->waitForPageLoad(30); // stepKey: clickAddToCartButtonWaitForPageLoad
		$I->waitForElementVisible("div.message-success.success.message", 30); // stepKey: waitForSuccessMessage
		$I->see("You added " . $I->retrieveEntityField('createProduct', 'name', 'test') . " to your shopping cart.", "div.message-success.success.message"); // stepKey: assertSuccessMessage
	}
}
