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
 * @Title("[NO TESTCASEID]: 'Item in Cart' is pluralized correctly")
 * @Description("When adding more then 1 item and check checkout page order summary section text 'Items in Cart' is pluralized correctly or not<h3>Test files</h3>app/code/Magento/Checkout/Test/Mftf/Test/StorefrontGuestCheckoutTest/StorefrontCheckoutSummaryItemsInCartLabelPluralizedTest.xml<br>")
 * @group Checkout
 */
class StorefrontCheckoutSummaryItemsInCartLabelPluralizedTestCest
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
		$createProductFields['price'] = "100.00";
		$I->createEntity("createProduct", "hook", "ApiSimpleProduct", ["createCategory"], $createProductFields); // stepKey: createProduct
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->deleteEntity("createProduct", "hook"); // stepKey: deleteSimpleProduct
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
	 * @Features({"Checkout"})
	 * @Stories({"Checkout page order summary section 'Item in Cart' is pluralized correctly or not"})
	 * @Severity(level = SeverityLevel::MINOR)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StorefrontCheckoutSummaryItemsInCartLabelPluralizedTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [openProductPage] StorefrontOpenProductPageActionGroup");
		$I->amOnPage("/" . $I->retrieveEntityField('createProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: openProductPageOpenProductPage
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadedOpenProductPage
		$I->comment("Exiting Action Group [openProductPage] StorefrontOpenProductPageActionGroup");
		$I->comment("Entering Action Group [enterProductQuantityAndAddToTheCart] StorefrontEnterProductQuantityAndAddToTheCartActionGroup");
		$I->clearField("#qty"); // stepKey: clearTheQuantityFieldEnterProductQuantityAndAddToTheCart
		$I->fillField("#qty", "1"); // stepKey: fillTheProductQuantityEnterProductQuantityAndAddToTheCart
		$I->click("#product-addtocart-button"); // stepKey: clickOnAddToButtonEnterProductQuantityAndAddToTheCart
		$I->waitForPageLoad(30); // stepKey: clickOnAddToButtonEnterProductQuantityAndAddToTheCartWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadEnterProductQuantityAndAddToTheCart
		$I->waitForElementVisible("div.message-success.success.message", 30); // stepKey: waitForSuccessMessageEnterProductQuantityAndAddToTheCart
		$I->comment("Exiting Action Group [enterProductQuantityAndAddToTheCart] StorefrontEnterProductQuantityAndAddToTheCartActionGroup");
		$I->comment("Entering Action Group [clickOnMiniCart] StorefrontClickOnMiniCartActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollToTheTopOfThePageClickOnMiniCart
		$I->waitForElementVisible("a.showcart", 30); // stepKey: waitForElementToBeVisibleClickOnMiniCart
		$I->waitForPageLoad(60); // stepKey: waitForElementToBeVisibleClickOnMiniCartWaitForPageLoad
		$I->click("a.showcart"); // stepKey: clickOnMiniCartClickOnMiniCart
		$I->waitForPageLoad(60); // stepKey: clickOnMiniCartClickOnMiniCartWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadClickOnMiniCart
		$I->comment("Exiting Action Group [clickOnMiniCart] StorefrontClickOnMiniCartActionGroup");
		$I->see("Item in Cart", "//*[@id='minicart-content-wrapper']/div[2]/div[1]/span[2]"); // stepKey: seeProductCountLabel
		$I->comment("Entering Action Group [openCheckoutPage] StorefrontOpenCheckoutPageActionGroup");
		$I->amOnPage("/checkout"); // stepKey: openCheckoutPageOpenCheckoutPage
		$I->waitForPageLoad(30); // stepKey: waitForCheckoutPageLoadedOpenCheckoutPage
		$I->comment("Exiting Action Group [openCheckoutPage] StorefrontOpenCheckoutPageActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForBundleProductCreatePageToLoad
		$I->see("Item in Cart", "//*[@id='opc-sidebar']/div[1]/div/div[1]/strong/span[2]"); // stepKey: seeFirstProductInList
		$I->comment("Entering Action Group [openProductPageAgain] StorefrontOpenProductPageActionGroup");
		$I->amOnPage("/" . $I->retrieveEntityField('createProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: openProductPageOpenProductPageAgain
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadedOpenProductPageAgain
		$I->comment("Exiting Action Group [openProductPageAgain] StorefrontOpenProductPageActionGroup");
		$I->comment("Entering Action Group [enterProductQuantityAndAddToTheCartAgain] StorefrontEnterProductQuantityAndAddToTheCartActionGroup");
		$I->clearField("#qty"); // stepKey: clearTheQuantityFieldEnterProductQuantityAndAddToTheCartAgain
		$I->fillField("#qty", "4"); // stepKey: fillTheProductQuantityEnterProductQuantityAndAddToTheCartAgain
		$I->click("#product-addtocart-button"); // stepKey: clickOnAddToButtonEnterProductQuantityAndAddToTheCartAgain
		$I->waitForPageLoad(30); // stepKey: clickOnAddToButtonEnterProductQuantityAndAddToTheCartAgainWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadEnterProductQuantityAndAddToTheCartAgain
		$I->waitForElementVisible("div.message-success.success.message", 30); // stepKey: waitForSuccessMessageEnterProductQuantityAndAddToTheCartAgain
		$I->comment("Exiting Action Group [enterProductQuantityAndAddToTheCartAgain] StorefrontEnterProductQuantityAndAddToTheCartActionGroup");
		$I->comment("Entering Action Group [clickOnMiniCartAgain] StorefrontClickOnMiniCartActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollToTheTopOfThePageClickOnMiniCartAgain
		$I->waitForElementVisible("a.showcart", 30); // stepKey: waitForElementToBeVisibleClickOnMiniCartAgain
		$I->waitForPageLoad(60); // stepKey: waitForElementToBeVisibleClickOnMiniCartAgainWaitForPageLoad
		$I->click("a.showcart"); // stepKey: clickOnMiniCartClickOnMiniCartAgain
		$I->waitForPageLoad(60); // stepKey: clickOnMiniCartClickOnMiniCartAgainWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadClickOnMiniCartAgain
		$I->comment("Exiting Action Group [clickOnMiniCartAgain] StorefrontClickOnMiniCartActionGroup");
		$I->see("Items in Cart", "//*[@id='minicart-content-wrapper']/div[2]/div[1]/span[2]"); // stepKey: seeProductCountLabelAgain
		$I->comment("Entering Action Group [openCheckoutPageAgain] StorefrontOpenCheckoutPageActionGroup");
		$I->amOnPage("/checkout"); // stepKey: openCheckoutPageOpenCheckoutPageAgain
		$I->waitForPageLoad(30); // stepKey: waitForCheckoutPageLoadedOpenCheckoutPageAgain
		$I->comment("Exiting Action Group [openCheckoutPageAgain] StorefrontOpenCheckoutPageActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForBundleProductCreatePageToLoadAgain
		$I->see("Items in Cart", "//*[@id='opc-sidebar']/div[1]/div/div[1]/strong/span[2]"); // stepKey: seeFirstProductInListAgain
	}
}
